import { qs, qsa, ce } from "./lib/dom-utils.js";
import { calculate, int, explicitSign } from "./utilities.js";
import { flushMsg } from "./ws-utilities.js";

// roll a dice expression and return expression an result
export function roll(code) {
    let result = 0,
        x,
        y,
        op,
        z;
    let match = /^(\d+)d(\d{0,3})([+-/*]*)([0-9\.]+)*/.exec(code);

    if (match === null) {
        result = isNaN(parseInt(code)) ? 0 : parseInt(code);
        (x = 0), (y = ""), (op = "+"), (z = result);
    } else {
        x = parseInt(match[1]);
        y = match[2] != "" ? parseInt(match[2]) : 6;
        op = match[3] != "" ? match[3] : "+";
        z = match[4] != undefined && match[4] != "" ? parseFloat(match[4]) : 0;

        // handling special cases: 1d-2 = 1d5-1, 1d-3 = 1d4-1, 1d-4 = 1d3-1, 1d-5=1d2-1
        if (x === 1 && y === 6 && op === "-" && z === 2) {
            result = Math.floor(Math.random() * 5);
        } else if (x === 1 && y === 6 && op === "-" && z === 3) {
            result = Math.floor(Math.random() * 4);
        } else if (x === 1 && y === 6 && op === "-" && z === 4) {
            result = Math.floor(Math.random() * 3);
        } else if (x === 1 && y === 6 && op === "-" && z <= 5) {
            result = Math.floor(Math.random() * 2);
        }

        // regular dices throw
        else {
            for (let i = 0; i < x; i++) {
                result += Math.floor(Math.random() * y) + 1;
            }
            switch (op) {
                case "+":
                    result += z;
                    break;
                case "-":
                    result -= z;
                    break;
                case "*":
                    result *= z;
                    break;
                case "/":
                    result /= z;
                    break;
            }
        }
    }
    let expression = `${x}d${y === 6 ? "" : y}${op}${z}`;
    expression = expression.replace("+0", "");
    expression = expression.replace("-0", "");
    return { expression: expression, result: result };
}

// given a score and a 3d roll result, returns the MR and the symbol of outcome status
export function scoreTester(score, roll) {
    const MR = score - roll;

    let critical = 0;
    if (roll === 18) {
        critical = -1;
    } else if (roll === 17) {
        critical = score >= 16 ? 0 : -1;
    } else if (roll === 4) {
        critical = score <= 5 ? 0 : 1;
    } else if (roll === 3) {
        critical = 1;
    } else if (MR <= -10) {
        critical = -1;
    } else if (MR >= 10 && roll <= 7) {
        critical = 1;
    }

    let outcomeSymbol = MR >= 0 ? "🟢" : "🔴";
    if (critical === -1) outcomeSymbol = "😖";
    if (critical === 1) outcomeSymbol = "😎";

    return { MR: MR, symbol: outcomeSymbol, critical: critical };
}

// get a damage expression from strength and code
export async function fetchDamageExpression(strength, code, hands) {
    if (parseInt(strength) && code) {
        let weaponCode = "B." + code;
        let data = new FormData();
        data.append("for", strength);
        data.append("notes", weaponCode);
        data.append("mains", hands);
        return fetch("/api/weapon-damages", {
            method: "post",
            body: data,
        })
            .then((response) => response.json())
            .then((response) => response.data.damages.slice(2));
    }
    return null;
}

// get a random localisation for a hit
export async function getLocalisation() {
    const data = new FormData();
    data.append("roll", roll("3d").result);
    const result = await fetch("/api/localisation-table", {
        method: "post",
        body: data,
    })
        .then((result) => result.json())
        .then((result) => result.data);
    return result;
}

// return the result of the get/post fetch query (url) with the given optionnel FormData (data) as decoded JSON
export async function fetchResult(url, data = null) {
    const params = { method: "get" };
    if (data) {
        params.method = "post";
        params.body = data;
    }
    return (
        fetch(url, params)
            //.then(response => response.text()) // debug
            //.then(response => console.log(response)) // debug
            .then((response) => response.json())
            .then((response) => response.data)
    );
}

export class Widget {
    constructor(name, action) {
        this.form = qs(`[data-name=${name}] form`);
        this.action = action.bind(this);
        this.form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const result = await this.action();
            if (result === null) return;
            qs("#msg-input").value += result;
            flushMsg("chat-roll");
        });
    }
}

export class Opponents {
    constructor(opponents) {
        this.wrapper = qs("[data-name=opponents] [data-role=opponents-wrapper]");
        this.template = qs("[data-name=opponents] template");
        this.list = opponents;

        if (this.list.length === 0) this.list = [{}];
        this.fillWidgets();
        this.updateOpponentSelectors();
        this.wrapper.addEventListener("change", (e) => this.updateOpponents(e));
    }

    fillWidgets() {
        this.list.forEach((opp, index) => {
            const wrapper = this.template.content.cloneNode(true);
            wrapper.querySelector("[data-role=opponent-wrapper]").dataset.index = index;
            wrapper.querySelector("[data-role=opponent-number]").innerText = index + 1;
            wrapper.querySelector("[name=name]").value = opp.name ?? "";
            wrapper.querySelector("[name=category]").value = opp.category ?? "std";
            wrapper.querySelector("[name=dex]").value = opp.dex ?? "";
            wrapper.querySelector("[name=san]").value = opp.san ?? "";
            wrapper.querySelector("[name=pain-resistance]").value = opp.painResistance ?? "";
            wrapper.querySelector("[name=pdvm]").value = opp.pdvm ?? "";
            wrapper.querySelector("[name=pdv]").value = opp.pdv ?? "";
            wrapper.querySelector("[name=members]").value = opp.members ?? "";
            this.wrapper.appendChild(wrapper);
        });
    }

    updateOpponents(event) {
        const wrapper = event.target.closest("[data-role=opponent-wrapper]");
        const index = parseInt(wrapper.querySelector("[data-role=opponent-number]").innerText) - 1;
        const param = event.target.name === "pain-resistance" ? "painResistance" : event.target.name;

        // data validation
        if (["dex", "san", "pdvm", "pdv"].includes(param)) event.target.value = calculate(event.target.value);
        if (["dex", "san", "pdvm"].includes(param) && event.target.value <= 0) event.target.value = "";
        if (param === "painResistance" && ![-1, 0, 1].includes(parseInt(event.target.value))) event.target.value = "";
        if (param === "members") event.target.value = event.target.value.toUpperCase();

        // updating this.list
        const value = event.target.value;
        this.list[index][param] = value !== "" && Number(value) == value ? parseInt(value) : value; // store value as int where relevant

        // deleting opponent without name
        if (param === "name" && value === "" && index < this.list.length - 1) wrapper.remove();

        // adding empty slot if last slot name is filled
        if (param === "name" && value !== "" && index === this.list.length - 1) {
            const wrapper = this.template.content.cloneNode(true);
            this.wrapper.appendChild(wrapper);
        }

        //if (param === "pdv") event.target.value = calculate(value);

        // filter opponents without name, keep last opponent empty
        this.list = this.list.filter((opp) => opp.name !== undefined && opp.name !== "");
        this.list.push({});

        // save in local storage
        localStorage.setItem("opponents", JSON.stringify(this.list));

        // update opponent wrappers numbering
        const numberWrappers = this.wrapper.querySelectorAll("[data-role=opponent-number]");
        let i = 1;
        numberWrappers.forEach((w) => {
            w.innerText = i;
            i++;
        });

        if (param === "name") this.updateOpponentSelectors();
    }

    updateOpponentSelectors() {
        const opponentSelects = qsa("[name=opponent-selector]");

        opponentSelects.forEach((selector) => {
            // update options list
            selector.innerHTML = "";
            if (Object.entries(this.list[0]).length === 0) {
                // if no opponent
                const option = ce("option");
                option.value = "";
                option.innerText = "–";
                selector.appendChild(option);
            } else {
                this.list.forEach((opp, index) => {
                    if (!opp.name) return;
                    const option = ce("option");
                    option.value = index;
                    option.innerText = opp.name;
                    selector.appendChild(option);
                });
            }

            // store choice on change
            selector.addEventListener("change", (e) => {
                localStorage.setItem("selected-opponent", e.target.value);
            });

            // display previous choice
            const selectedOpponentIndex = localStorage.getItem("selected-opponent") ?? 0;
            if (selector.children[selectedOpponentIndex]) selector.children[selectedOpponentIndex].selected = true;
        });
    }
}

export class Scores {
    constructor(scores) {
        this.wrapper = qs("[data-name=scores-tester] [data-role=scores-wrapper]");
        this.sortBtn = qs("[data-name=scores-tester] [data-role=sort-scores]");
        this.template = qs("[data-name=scores-tester] template");
        this.skills = scores;

        if (this.skills.length === 0) this.skills = [{}];
        this.fillWidgets();
        this.wrapper.addEventListener("change", (e) => this.updateScores(e));

        // sorting button
        this.sortBtn.addEventListener("click", (e) => {
            this.skills = this.skills.sort((a, b) => {
                if (a.name && b.name) return a.name.localeCompare(b.name, "fr", { sensitivity: "base" }); // If both have names, compare them
                if (a.name && !b.name) return -1; // If a has a name but b doesn't, a comes first
                if (!a.name && b.name) return 1; // If b has a name but a doesn't, b comes first
                return 0;
            });
            this.wrapper.innerHTML = "";
            this.fillWidgets();
            localStorage.setItem("skills", JSON.stringify(this.skills));
        });
    }

    // append individual widgets in local storage to wrapper
    fillWidgets() {
        this.skills.forEach((skill, index) => {
            const wrapper = this.template.content.cloneNode(true);
            const form = wrapper.querySelector("form");
            form.dataset.index = index;
            form.name.value = skill.name ?? "";
            form.score.value = skill.score ?? "";
            form.modif.value = skill.modif ?? "";
            form.addEventListener("submit", (event) => this.action(event, skill));
            this.wrapper.appendChild(wrapper);
        });
    }

    // submit a score test from a widget
    action(event, skill) {
        event.preventDefault();

        // If skill is empty, try to get it from the array
        if (!skill || Object.keys(skill).length === 0) {
            const index = parseInt(event.target.dataset.index);
            skill = this.skills[index] || {};
        }

        const rollResult = roll("3d").result;
        const testResult = scoreTester(skill.score + (skill.modif ?? 0), rollResult);
        const readableModif = skill.modif === 0 || skill.modif === "" || skill.modif === undefined ? "" : explicitSign(skill.modif);
        if (skill.name === undefined || skill.name === "" || skill.score === undefined || Number(skill.score) != skill.score) return;
        qs("#msg-input").value += `${skill.name} (${skill.score}${readableModif}) → ${rollResult} (MR ${testResult.MR} ${testResult.symbol})`;
        flushMsg("chat-roll", testResult.symbol);
    }

    // add, update or delete individual score widget
    updateScores(event) {
        const wrapper = event.target.closest("form");
        const index = parseInt(wrapper.dataset.index);
        const param = event.target.name; // name of input that changed

        // data validation
        if (param === "score" || param === "modif") event.target.value = calculate(event.target.value);
        if (param === "modif") event.target.value = explicitSign(event.target.value);

		// update skill in this.skills
        const value = event.target.value;
        this.skills[index][param] = value !== "" && Number(value) == value ? parseInt(value) : value; // store value as int where relevant

        // delete empty skills
        if (param === "name" && value === "") wrapper.remove();

        // adding empty slot if last slot name is filled
        if (param === "name" && value !== "" && index === this.skills.length - 1) {
            const wrapper = this.template.content.cloneNode(true);
            wrapper.querySelector("form").addEventListener("submit", (event) => this.action(event, {}));
            this.wrapper.appendChild(wrapper);
        }

        // filter skills without name, keep last skill empty
        this.skills = this.skills.filter((skill) => skill.name !== undefined && skill.name !== "");
        this.skills.push({});

        // save in local storage
        localStorage.setItem("skills", JSON.stringify(this.skills));

        // update skills index numbering
        const widgets = this.wrapper.querySelectorAll("form");
        let i = 0;
        widgets.forEach((w) => {
            w.dataset.index = i;
            i++;
        });
    }
}
