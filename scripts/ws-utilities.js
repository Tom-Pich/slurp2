"use strict";

import { calculate, int } from "./utilities.js";
import { roll, scoreTester, getLocalisation } from "./game-table-utilities.js";

export const wsURL = window.location.hostname === "site-jdr" ? "ws://127.0.0.1:1337" : "wss://web-chat.pichegru.net:443";

export class Message {
    constructor(sender, key, type, content, recipients = [], label = null) {
        this.sender = parseInt(sender); // sender ID
        this.key = key; // "secret" key (see .env)
        this.type = type;
        this.timestamp = Date.now();
        this.content = content;
        this.recipients = recipients;
        this.label = label; // for extra-data not covered by type or content
    }
    stringify() {
        return JSON.stringify(this);
    }
}

/**
 * function fired on "enter": handle special inputs, send the message and clean the text entry
 * @param {WebSocket} ws Websocket connection
 * @param {int} id of the sender
 * @param {string} key secret key (see .env)
 * @param {string} type of message
 * @param {HTMLElement} inputEntry where message is entered
 * @param {string} label extra info
 */
// 
export async function flushMsg(type, label = null) {

	// get necessary data outside module scope
	const inputEntry = window.chat.inputEntry;
	const id = window.chat.id;
	const key = window.chat.key;
	const ws = window.chat.ws;

    // extract recipients from entry (like /1,2)
    const recipientsRegexp = /^\/(\d+,){0,10}\d+/;
    const recipientsRegexpResult = recipientsRegexp.exec(inputEntry.value);
    let recipients = [];
    if (recipientsRegexpResult) {
        recipients = recipientsRegexpResult[0].substring(1).split(","); // array of recipients ID
        recipients = recipients.map((id) => parseInt(id)); // conversion of IDs in int
        inputEntry.value = inputEntry.value.replace(recipientsRegexpResult[0], "").trim(); // delete recipient from message text
    }

    // handle inline tests and rolls
    const inlineTestRegexp = /#\d{1,2}([+-]\d{1,2})?(?=\s|$)/g; // search for expressions like #7 or #13-2 followed by a space or the end of the expression
    const inlineRollRegexp = /#(\d+)d(\d{0,3})([+-/*]*)([0-9\.]+)*/g; // search for expressions like #1d+2 or #6d*2
	const inlineDamageRegexp = /D(\d+)d(\d{0,3})([+-/*]*)([0-9\.]+)*/g; // search for expressions like D1d+2
    const inlineTestRegexpResult = inputEntry.value.match(inlineTestRegexp);
    const inlineRollRegexpResult = inputEntry.value.match(inlineRollRegexp);
    const inlineDamageRegexpResult = inputEntry.value.match(inlineDamageRegexp);

    if (inlineTestRegexpResult) {
        const scores = [];
        inlineTestRegexpResult.forEach((match) => {
            scores.push(match.replace("#", "")); // extract scores and parse them to integer
        });
        scores.forEach((score) => {
            const rollResult = roll("3d").result;
            const netScore = calculate(score);
            const outcome = scoreTester(netScore, rollResult);
            const detailledResult = `[ ${score} → ${rollResult} (MR ${outcome.MR} ${outcome.symbol}) ]`;
            inputEntry.value = inputEntry.value.replace(`#${score}`, detailledResult); // replace #xx by detailled outcome
            if (scores.length === 1 && inlineRollRegexpResult === null) label = outcome.symbol; // label stays null if more than one test
        });
    }

    if (inlineRollRegexpResult) {
        const expressions = [];
        inlineRollRegexpResult.forEach((match) => {
            expressions.push(match.replace("#", "")); // extract roll expressions
        });
        expressions.forEach((expression) => {
            const rollResult = roll(expression).result;
            const detailledResult = `[ ${expression} → ${rollResult} ]`;
            inputEntry.value = inputEntry.value.replace(`#${expression}`, detailledResult); // replace #xd+y by detailled outcome
        });
    }

	if (inlineDamageRegexpResult){
		const expressions = [];
        inlineDamageRegexpResult.forEach((match) => {
            expressions.push(match.replace("D", "")); // extract roll expressions
        });
		const promises = expressions.map(async (expression) => {
			const rollResult = roll(expression).result;
			const localisation = await getLocalisation();
			const detailledResult = `[ ${expression} → ${rollResult} – ${localisation[1]} ]`;
			inputEntry.value = inputEntry.value.replace(`D${expression}`, detailledResult); // replace Dxd+y by detailled outcome
		});

		await Promise.all(promises);
	}

    if (inlineTestRegexpResult || inlineRollRegexpResult || inlineDamageRegexpResult ) type = "chat-roll"; // changing message type

    const message = new Message(id, key, type, inputEntry.value, recipients, label);
    ws.send(message.stringify());
    inputEntry.value = "";
}
