import { qs, qsa } from "./lib/dom-utils.js";
import { updateDOM } from "./update-dom.js";
//import { fetchResult } from "./game-table-utilities";

const filterForm = qs("[data-role=filter-form]");
const displayInputs = qsa("[name=affichage]");
const rangeFilter = qs("[data-role=range-filter]");
const originInputs = qsa("[data-role=origin-selector]");
const keywordInput = qs("[name=keyword]");

// prevent form submit
filterForm.addEventListener("submit", (e) => e.preventDefault());

// set lazy load event listeners on load
//setLazyloadingListeners();

// update page when display type changes (categories or alphabetical)
displayInputs.forEach((input) => {
    input.addEventListener("change", (e) => {
        const data = new FormData();
        data.append("affichage", input.value);
        fetch(filterForm.action, {
            method: "POST",
            body: data,
        })
            .then((response) => response.text())
            .then((response) => {
                updateDOM("main", response);
                filterSpells();
                filterSkills();
                filterAvdesavs();
                //setLazyloadingListeners();
            });
    });
});

// reactivity to level input
let rangeFilterDelayId;
rangeFilter.addEventListener("keyup", (e) => {
    if (rangeFilterDelayId) clearTimeout(rangeFilterDelayId);
    rangeFilterDelayId = setTimeout(filterSpells, 500);
});

// reactivity to origin checkboxes
originInputs.forEach((checkbox) => {
    checkbox.addEventListener("change", (e) => {
        filterSpells();
    });
});

// reactivity to keyword input
if (keywordInput) {
    keywordInput.addEventListener("keyup", (e) => {
        filterSpells();
        filterSkills();
        filterAvdesavs();
    });
}

// Filter spells by level and/or origin and/or keyword
function filterSpells() {
    const spells = qsa("[data-role=spells-wrapper] .liste");

    const origins = [];
    if (originInputs.length) {
        originInputs.forEach((checkbox) => {
            if (checkbox.checked) origins.push(checkbox.value);
        });
    } else {
        origins.push("RdB");
    }

    const rangeFilterArray = rangeFilter.value.split("-");
    const min = parseInt(rangeFilterArray[0]);
    const max = parseInt(rangeFilterArray[1] || min);
    if (min > max) [min, max] = [max, min];

	const keyword = keywordInput ? keywordInput.value : ""; // no early return because of level filter

	spells.forEach((spell) => {
		const spellName = spell.querySelector("summary div:first-of-type").textContent;
		const spellNameMatchesKeyword = keywordMatch(spellName, keyword) || keyword.length <= 2;
		if (spell.dataset.nivMin > max || spell.dataset.nivMax < min || !origins.includes(spell.dataset.origin) || !spellNameMatchesKeyword) {
			spell.classList.add("hidden");
		} else {
			spell.classList.remove("hidden");
		}
	});

    hideEmptyCategories();
}

// Filter skills by keyword
function filterSkills() {
    if (!keywordInput) return;
    const skills = qsa("[data-role=skills-wrapper] .liste");
    const keyword = keywordInput.value;

    skills.forEach((item) => {
        const itemName = item.querySelector("summary").textContent;
        //console.log(itemName)
        const itemNameMatchesKeyword = keywordMatch(itemName, keyword) || keyword.length <= 2;
        if (!itemNameMatchesKeyword) item.classList.add("hidden");
        else item.classList.remove("hidden");
    });

    hideEmptyCategories();
}

// Filter Avdesavs by keyword
function filterAvdesavs() {
    if (!keywordInput) return;
    const avdesavs = qsa("[data-role=avdesavs-wrapper] .liste");
    const keyword = keywordInput.value;

    avdesavs.forEach((item) => {
        const itemName = item.querySelector("summary").textContent;
        const itemNameMatchesKeyword = keywordMatch(itemName, keyword) || keyword.length <= 2;
        if (!itemNameMatchesKeyword) item.classList.add("hidden");
        else item.classList.remove("hidden");
    });

    hideEmptyCategories();
}

// hide empty categories
function hideEmptyCategories() {
    const categorieWrappers = qsa(":is([data-role=avdesavs-wrapper], [data-role=skills-wrapper], [data-role=spells-wrapper]) details:not(.liste)");
    categorieWrappers.forEach((wrapper) => {
        const items = wrapper.querySelectorAll(".liste:not(.hidden)");
        if (!items.length) wrapper.classList.add("hidden");
        else wrapper.classList.remove("hidden");
    });
}

// check keyword match in expression, ignoring cases and accents
function keywordMatch(expression, keyword) {
    const normalizedKeyword = keyword
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "");
    const normalizedExpression = expression
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "");
    return normalizedExpression.includes(normalizedKeyword);
}

// lazy load event listener → deported to item-lazy-load.js
/* function setLazyloadingListeners() {
    const lazyItems = qsa("[data-details]");

    lazyItems.forEach((item) => {
        const itemDetail = item.closest("details.liste");
        itemDetail.addEventListener("click", async (e) => {
            const descriptionWrapper = e.target.closest("details.liste").querySelector("[data-details]");
            const id = parseInt(descriptionWrapper.dataset.id);
            if (descriptionWrapper.dataset.type === "spell") {
                const spell = await fetchResult("/api/get-spell?id=" + id);
                descriptionWrapper.innerHTML = spell.fullDescription;
            }
            if (descriptionWrapper.dataset.type === "avdesav") {
                const avdesav = await fetchResult("/api/get-avdesav?id=" + id);
                descriptionWrapper.innerHTML = avdesav.description;
            }
            if (descriptionWrapper.dataset.type === "creature") {
                const creature = await fetchResult("/api/get-creature?id=" + id);
                descriptionWrapper.innerHTML = creature.description;
            }
        });
    });
} */
