import {qs, qsa} from "./utilities";

const wrapper = qs("[data-role=spells-wrapper]") || qs("[data-role=powers-wrapper]");

const spells = wrapper.querySelectorAll(".liste");
const rangeInput = qs("[data-role=range-filter]")
const originInputs = qsa("[data-role=origin-selector]")

rangeInput.addEventListener("keyup", (e) => {
	let spellRange = e.target.value
	spellRange = spellRange.split("-");
	let min = parseInt(spellRange[0]) ;
	let max = parseInt(spellRange[1] || min) ;
	if (min > max){
		[min, max] = [max, min]
	}
	spells.forEach(spell => {
		if(spell.dataset.nivMin > max || spell.dataset.nivMax < min ){
			spell.classList.add("hidden");
		} else {
			spell.classList.remove("hidden");
		}
	});
})

originInputs.forEach( box => {
	box.addEventListener("change", (e) => {
		const origin = e.target.value;
		const filtered = !e.target.checked;

		spells.forEach(spell => {
			if(spell.dataset.origin === origin ){
				filtered ? spell.classList.add("hidden") : spell.classList.remove("hidden");
			}
		});

	})
})
