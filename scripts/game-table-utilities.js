import { qs, qsa, ce, calculate, int, explicitSign } from "./utilities.js";

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

// get a random localisation for a hit
export async function getLocalisation() {
    let data = new FormData();
    data.append("roll", roll("3d").result);
    const result = await fetch("/api/localisation-table", {
        method: "post",
        body: data,
    })
        .then((result) => result.json())
        .then((result) => result.data);
    return result;
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
        //.then(damage => wdwExpression.value = damage)
    }
}

/** given a score and a 3d roll result, returns the MR and the symbol of outcome status */
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

/** return the result of the post fetch query (url) with the given data (data) as decoded JSON */
export async function fetchResult(url, data) {
    return (
        fetch(url, {
            method: "post",
            body: data,
        })
            //.then(response => response.text()) // debug
            //.then(response => console.log(response)) // debug
            .then((response) => response.json())
            .then((response) => response.data)
    );
}

// ––– opponent utilities ––––––
export class Opponent {

	static mountNewOpponent(opponents) {
		const lastOpponent = opponents[opponents.length - 1];
		const lastOpponentNumber = int(lastOpponent.dataset.opponent);
		const newOpponent = new Opponent(lastOpponent.cloneNode(true));
		newOpponent.setNumber(lastOpponentNumber+1);
		newOpponent.mount(lastOpponent);
		newOpponent.reset();
	}

	static unmountLastOpponent(opponents) {
		const lastOpponent = new Opponent(opponents[opponents.length - 1]);
		lastOpponent.unmount();
	}

    constructor(opponent) {
        this.opponentProps = ["name", "category", "dex", "san", "pain-resistance", "pdvm", "pdv", "members"];
        this.opponentSelects = qsa("[name=opponent-selector]");
        this.wrapper = opponent;
        this.number = opponent.dataset.opponent;
        // set opponent.name, opponent.category, opponent.dex, etc (these are inputs!)
        this.opponentProps.forEach((data) => (this[data] = this.wrapper.querySelector(`[name=${data}]`)));
    }

    importFromLocalStorage() {
        const localStorageData = localStorage.getItem(`opponent-${this.number}`);
        if (localStorageData) {
            const savedData = JSON.parse(localStorageData);
            this.opponentProps.forEach((data) => (this[data].value = savedData[data]));
        }
    }

    save() {
        const savedData = {};
        this.opponentProps.forEach((data) => (savedData[data] = this[data].value));
        localStorage.setItem(`opponent-${this.number}`, JSON.stringify(savedData));
    }

    reset() {
        this.opponentProps.forEach((data) => (this[data].value = ""));
        this.category.value = "std";
        localStorage.removeItem(`opponent-${this.number}`);
    }

    addToOpponentSelectors() {
        this.opponentSelects.forEach((select) => {
            const option = ce("option");
            option.value = this.number;
            option.innerText = this.name.value !== "" ? this.name.value : `Protagoniste ${this.number}`;
            select.appendChild(option);
        });
    }

    updateNameInOpponentSelectors() {
        this.opponentSelects.forEach((select) => {
            select.options[this.number - 1].innerText = this.name.value !== "" ? this.name.value : `Protagoniste ${this.number}`;
        });
    }

	setReactivity(){
		this.importFromLocalStorage();
		this.addToOpponentSelectors();

		// event listener
		this.wrapper.addEventListener("keyup", (e) => {
			if (e.target.name === "name" && e.target.value === "") this.reset();
			else this.save();
		});
		this.category.addEventListener("change", (e) => this.save());
		this.name.addEventListener("keyup", (e) => this.updateNameInOpponentSelectors());
		this.name.dispatchEvent(new Event("keyup"));
		this.pdvm.addEventListener("blur", (e) => {
			if (this.pdv.value === "") this.pdv.value = this.pdvm.value;
		});
		this.pdv.addEventListener("blur", (e) => {
			this.pdv.value = calculate(this.pdv.value);
			this.save();
		});
	}

	setNumber(x){
		this.number = x;
		this.wrapper.dataset.opponent = x;
		this.wrapper.querySelector("[data-role=opponent-number]").innerText = x;
	}

	mount(previousSibling){
		this.wrapper.classList.add("mt-½");
		previousSibling.parentNode.insertBefore(this.wrapper, previousSibling.nextSibling);
		this.setReactivity();
		// referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
	}

	unmount(){
		localStorage.removeItem(`opponent-${this.number}`);
		this.wrapper.remove();
		this.opponentSelects.forEach( select => select.children[this.number-1].remove())
	}
}

// ––– score tester utilities –––––––––––
export function setScoreWidget(widget, inputEntry, flushMsg) {
    const skill = {};
    skill.name = widget.querySelector("[data-type=skill-name]");
    skill.number = skill.name.dataset.skillNumber;
    skill.score = widget.querySelector("[data-type=score]");
    skill.modifier = widget.querySelector("[data-type=modif]");

    // load data from localStorage
    if (localStorage.getItem(`skill-${skill.number}`)) {
        const savedData = JSON.parse(localStorage.getItem(`skill-${skill.number}`));
        skill.name.value = savedData.name;
        skill.score.value = savedData.score;
    }

    // clean or save input values when changed
    const events = ["keyup", "change"];
    events.forEach((event) => {
        widget.addEventListener(event, (e) => {
            if (skill.name.value === "") {
                skill.score.value = "";
                localStorage.removeItem(`skill-${skill.number}`);
            } else {
                const savedData = { name: skill.name.value, score: skill.score.value };
                localStorage.setItem(`skill-${skill.number}`, JSON.stringify(savedData));
            }
        });
    });

    widget.addEventListener("submit", (e) => {
        if (isNaN(parseInt(skill.score.value)) || skill.name.value === "") return;
        const modif = int(skill.modifier.value);
        const netScore = int(skill.score.value) + modif;
        const diceResult = roll("3d").result;
        const outcome = scoreTester(netScore, diceResult);
        const readableModif = modif === 0 ? "" : explicitSign(modif);
        inputEntry.value += `${skill.name.value} (${skill.score.value}${readableModif}) → ${diceResult} (MR ${outcome.MR} ${outcome.symbol})`;
        flushMsg("chat-roll", outcome.symbol);
    });
}

export function mountNewScoreWidget(scoreWidgets, inputEntry, flushMsg) {
    const lastScore = scoreWidgets[scoreWidgets.length - 1];
    const lastScoreNumber = int(lastScore.querySelector("[data-skill-number]").dataset.skillNumber);
    const newScore = lastScore.cloneNode(true);
    newScore.querySelector("[data-skill-number]").dataset.skillNumber = lastScoreNumber + 1;
    lastScore.parentElement.appendChild(newScore);
    newScore.addEventListener("submit", (e) => e.preventDefault());
    setScoreWidget(newScore, inputEntry, flushMsg);
}

export function unmountScoreWidget(scoreWidgets) {
    const lastScore = scoreWidgets[scoreWidgets.length - 1];
    const lastScoreNumber = int(lastScore.querySelector("[data-skill-number]").dataset.skillNumber);
    lastScore.remove();
    localStorage.removeItem(`skill-${lastScoreNumber}`);
}
