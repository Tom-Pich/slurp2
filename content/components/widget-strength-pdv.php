<fieldset id="widget-weight-strength-pdv" class="widget">
	<legend>Poids, Force &amp; PdV</legend>
	<div class="grid col-3-s gap-½ ta-center">
		<div class="fw-700">Poids (kg)</div>
		<div class="fw-700">For</div>
		<div class="fw-700">PdV</div>
		<input type="text" name="weight" class="border-grey-700 ta-center">
		<div class="border-grey-700" data-role="strength-wrapper"></div>
		<div class="border-grey-700" data-role="pdv-wrapper"></div>
	</div>
</fieldset>

<script type="module">
	import { fetchResult } from "/scripts/game-table-utilities";

	const widget = document.querySelector("#widget-weight-strength-pdv");
	const weightInput = widget.querySelector("[name=weight]");
	const strengthWrapper = widget.querySelector("[data-role=strength-wrapper]");
	const pdvWrapper = widget.querySelector("[data-role=pdv-wrapper]");

	weightInput.addEventListener("keyup", () => {
		const weight = parseFloat(weightInput.value)
		if (!isNaN(weight) && weight > 0) {
			fetchResult(`/api/weight-strength?weight=${weight}&interval=true`).then(strength => strengthWrapper.innerText = strength );
			fetchResult(`/api/weight-pdv?weight=${weight}&interval=true`).then(pdv => pdvWrapper.innerText = pdv );
		}
	})
</script>