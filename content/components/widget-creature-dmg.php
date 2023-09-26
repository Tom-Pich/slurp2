<fieldset class="widget">
	<legend>Dégâts des animaux</legend>
	<div class="flex-s gap-½ ai-first-baseline jc-space-between mt-½">
		<div>
			<label>Force</label>&nbsp;
			<input type="text" style="width: 8ch" class="ta-center" data-role="strength-input">
		</div>
		<div>
			<label>Poids (kg)</label>&nbsp;
			<input type="text" style="width: 8ch" class="ta-center" data-role="weight-input">
		</div>
	</div>
	<div class="mt-1">
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