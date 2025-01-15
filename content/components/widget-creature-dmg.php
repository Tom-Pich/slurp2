<fieldset id="widget-creature-dmg" class="widget flow">
	<legend>Dégâts des animaux</legend>
	<div class="flex-s gap-½ ai-first-baseline jc-space-between mt-½">
		<div>
			<label>Force</label>&nbsp;
			<input type="text" style="width: 8ch" class="ta-center" name="strength">
		</div>
		<div>
			<label>Poids (kg)</label>&nbsp;
			<input type="text" style="width: 8ch" class="ta-center" name="weight">
		</div>
	</div>
	<div>
		<ul>
			<li>Estoc&nbsp;: <span data-role="estoc-dmg-wrapper"></span></li>
			<li>Taille&nbsp;: <span data-role="taille-dmg-wrapper"></span></li>
			<li>Morsure*, griffes, ruade&nbsp;: <span data-role="bite-dmg-wrapper"></span></li>
			<li>Cornes&nbsp;: <span data-role="horns-dmg-wrapper"></span></li>
			<li>Piétinement**&nbsp;: <span data-role="trampling-dmg-wrapper"></span></li>
		</ul>
	</div>
</fieldset>
<div class="mt-½">
	* Herbivores&nbsp;: dégâts de <i>Broyage</i> basés sur le <i>tiers</i> de la <i>For</i> de la créature.<br>
	** Ne prendre en compte qu’un quart du poids réel si la créature n’a pas de sabot.
</div>

<script type="module">
	import {fetchResult} from "/scripts/game-table-utilities.js"

	const widget = document.querySelector("#widget-creature-dmg");

	const strengthInput = widget.querySelector("[name=strength]");
	const weightInput = widget.querySelector("[name=weight]");
	const estocWrapper = widget.querySelector("[data-role=estoc-dmg-wrapper]")
	const tailleWrapper = widget.querySelector("[data-role=taille-dmg-wrapper]")
	const biteWrapper = widget.querySelector("[data-role=bite-dmg-wrapper]")
	const hornsWrapper = widget.querySelector("[data-role=horns-dmg-wrapper]")
	const tramplingWrapper = widget.querySelector("[data-role=trampling-dmg-wrapper]")

	strengthInput.addEventListener("keyup", (e) => {
		const strength = parseInt(e.target.value)
		if (!isNaN(strength) && strength > 0) {
			fetchResult(`/api/strength-damages?strength=${strength}`)
				.then(damages => {
					estocWrapper.innerText = damages.estoc;
					tailleWrapper.innerText = damages.taille;
					biteWrapper.innerText = damages.morsure;
					hornsWrapper.innerText = damages.cornes;
				})
		}
	})

	weightInput.addEventListener("keyup", (e) => {
		const weight = parseFloat(e.target.value)
		if (!isNaN(weight) && weight > 0) {
			fetchResult(`/api/trampling-damages?weight=${weight}`)
				.then(damages => {
					tramplingWrapper.innerText = damages
				})
		}
	})
</script>