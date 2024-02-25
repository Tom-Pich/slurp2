import { qs } from "./utilities";

const widget = qs("#armor-widget");
const inputs = widget.querySelectorAll("input, select");
inputs.forEach( input => {
	input.addEventListener("change", () => {
		calculate_armor_data();
	})
})
calculate_armor_data();

function calculate_armor_data(){
	const size_weight_mult = parseFloat(qs("#armor-size").selectedOptions[0].dataset.weight);
	const size_price_mult = parseFloat(qs("#armor-size").selectedOptions[0].dataset.price);
	const global_type = qs("#armor-type").value;
	const global_quality = qs("#armor-quality").value;
	const global_enchantment = qs("#armor-enchantment").value;

	// select part type from global type
	if(global_type !== "0"){
		const selects = widget.querySelectorAll("[data-type=armor-type]")
		selects.forEach(select => { select.value = global_type; })
	}

	// select part quality from global quality
	if(global_quality !== "std"){
		const selects = widget.querySelectorAll("[data-type=armor-quality]")
		selects.forEach(select => { select.value = global_quality; })
	}

	// select part enchantment from global enchantment
	if(global_enchantment !== "0"){
		const selects = widget.querySelectorAll("[data-type=armor-enchantment]")
		selects.forEach(select => { select.value = global_enchantment; })
	}

	// reset global choices
	qs("#armor-type").value = 0;
	qs("#armor-quality").value = "std";
	qs("#armor-enchantment").value = 0;

	// process each rows data
	let total_weight = 0;
	let total_price = 0;
	const rows = widget.querySelectorAll("[data-type=armor-row]")
	rows.forEach(row => {
		const selects = row.querySelectorAll("select");
		const type_selected_option = selects[0].selectedOptions[0];
		const quality_selected_option = selects[1].selectedOptions[0];
		const enchantment_selected_option = selects[2].selectedOptions[0];
		const is_halfed = row.querySelector("input").checked;

		const base_weight = parseFloat(type_selected_option.dataset.weight);
		const base_price = parseFloat(type_selected_option.dataset.price);

		const part_weight_mult = parseFloat(row.dataset.weight);
		const part_price_mult = parseFloat(row.dataset.price);

		const quality_weight_mult = parseFloat(quality_selected_option.dataset.weight);
		const quality_price_mult = parseFloat(quality_selected_option.dataset.price);

		const echantment_weight_mult = parseFloat(enchantment_selected_option.dataset.weight);
		const enchantment_price_mult = 1;

		const final_weight = (base_weight*size_weight_mult*part_weight_mult*quality_weight_mult*echantment_weight_mult*(is_halfed ? 0.5 : 1)).toFixed(2);
		const final_cost = Math.round(base_price*size_price_mult*part_price_mult*quality_price_mult*enchantment_price_mult*(is_halfed ? 0.5 : 1));

		total_weight += parseFloat(final_weight);
		total_price += parseInt(final_cost);

		row.children[1].innerText = final_weight > 0 ? final_weight : "" ;
		row.children[2].innerText = final_cost > 0 ? final_cost : "";
	})

	// add total weight and cost
	const total_row = qs("#armor-total");
	total_row.children[1].innerText = Math.round(total_weight*10)/10 ;
	total_row.children[2].innerText = total_price;
}