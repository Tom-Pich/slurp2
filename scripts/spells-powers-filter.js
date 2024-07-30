import {qs, qsa} from "./utilities";

const wrapper = qs("[data-role=spells-wrapper]");
const spells = wrapper.querySelectorAll(".liste");
const rangeFilter = qs("[data-role=range-filter]");
const originInputs = qsa("[data-role=origin-selector]");
const collegeWrappers = qsa("[data-role=college-wrapper]");

function filterSpells(){

	const origins = [];
	if(originInputs.length === 0) origins.push("RdB")
	originInputs.forEach( checkbox => {
		if(checkbox.checked) origins.push(checkbox.value)
	} )
	console.log(origins)

	const rangeFilterArray = rangeFilter.value.split("-");
	const min = parseInt(rangeFilterArray[0]) ;
	const max = parseInt(rangeFilterArray[1] || min) ;
	if (min > max){
		[min, max] = [max, min]
	}
	console.log(min, max)

	spells.forEach(spell => {
		if(spell.dataset.nivMin > max || spell.dataset.nivMax < min || !origins.includes(spell.dataset.origin) ){
			spell.classList.add("hidden");
		} else {
			spell.classList.remove("hidden");
		}
	});

	collegeWrappers.forEach(college => {
		console.log(college)
		const spellsFromCollege = college.querySelectorAll(".liste:not(.hidden)")
		console.log(spellsFromCollege)
		if (spellsFromCollege.length === 0) {college.classList.add("hidden")}
		else { college.classList.remove("hidden") }
	})
}


let delayId
rangeFilter.addEventListener("keyup", (e) => {
	if (delayId) clearTimeout(delayId)
	delayId = setTimeout( filterSpells, 500 )
})

originInputs.forEach(checkbox => {
	checkbox.addEventListener("change", (e) => {
		filterSpells()
	})
})
