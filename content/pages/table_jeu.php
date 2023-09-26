<?php
$nbre_protagonistes = 8;
?>

<article>

<div>
	<form onsubmit="return false"><!-- jet de dés simple -->
		<fieldset><legend>Jet de dés simple</legend>
			<div class="flex-between">
				<div class="flex1 center">
					<input type="text" size="5" id="jet1" class="center" placeholder="xd±y" value="3d" title="Expression de type xd(y)(+-/* z)" />
				</div>
				<button class="nude" onclick="roll_dices()" title="Jet de dés – Alt+Shift+R" accesskey="r" >&#x1F3B2;</button>
			</div>
		</fieldset>
	</form>

	<fieldset><legend>Jets de réussite</legend><!-- test caractéristique / compétence -->
		<?php for($i=0 ; $i<7 ; $i++){ ?>
			<form onsubmit="return false" class="flex-between">
				<div>
					<input type="text" size="15" placeholder="Comp. ou carac." title="Compétence ou caractéristique à tester" list="liste-carac-comp"/>
					<datalist id="liste-carac-comp">
						<option value="Force"></option>
						<option value="Dextérité"></option>
						<option value="Intelligence"></option>
						<option value="Santé"></option>
						<option value="Perception"></option>
						<option value="Volonté"></option>
						<option value="Esquive"></option>
						<option value="Hache/Masse"></option>
						<option value="Épée"></option>
						<option value="Arc"></option>
						<option value="Arbalète"></option>
						<option value="Combat à mains nues"></option>
						<option value="Culture générale"></option>
						<option value="Furtivité"></option>
					</datalist>
					<input type="text" size="5" class="center" placeholder="score" title="score de la comp. ou de la carac." />
					<input type="text" size="5" class="center" placeholder="modif" title="Modificateur du jet (laisser blanc si zéro)" />
				</div>
				<button class="nude" onclick="test_3d_table(this)">&#x1F3B2;</button>
			</form>
		<?php ;} ?>
	</fieldset>
	

	<form onsubmit="return false"><!-- dégâts et localisation -->
		<fieldset><legend>Dégâts et localisation</legend>
		<div class="flex-between">
			<div>
				<input type="text" size="3" id="as-force" class="center" placeholder="For" onkeyup="calcul_code_des()" title="For de l’attaquant" />
				<input type="text" size="3" id="as-code-arme" class="center" placeholder="Code" onkeyup="calcul_code_des()" title="Code dégâts de l’arme" />
				<select id="as-mains" onchange="calcul_code_des()" style="width: 80px" title="Préciser le maniement de l’arme">
					<option value="1M">1 main</option>
					<option value="2M-opt">2 mains opt.</option>
					<option value="2M">2 mains</option>
				</select>
				<b>ou</b>
				<input type="text" size="3" id="as-code-degats" class="center" placeholder="xd±y" title="Expression des dégâts de type xd(y)(+-/* z)"/>&emsp;
			</div>
			<button class="nude" onclick="calcul_deg_arme()" >&#x1F3B2;</button>
		</div>
		</fieldset>
	</form>

	<form onsubmit="return false"><!-- Critiques & maladresses -->
		<fieldset><legend>Critiques &amp; maladresses</legend>
		<div class="flex-between">
			<div>
				<select name="crit_type" id="critiques">
					<option value="rc_attaque">Réussite critique en attaque</option>
					<option value="ec_arme_contact">Échec critique arme de contact</option>
					<option value="ec_arme_projectiles">Échec critique arme à projectiles</option>
					<option value="ec_arme_jet">Échec critique arme de jet</option>
					<option value="ec_mouvement">Échec critique en mouvement</option>
					<option value="ec_sort">Échec critique en magie</option>
				</select>
			</div>
			<button class="nude" onclick="roll_critique()" >&#x1F3B2;</button>
		</div>
		</fieldset>
	</form>

	<form onsubmit="return false"><!-- rafale -->
		<fieldset><legend>Tir en rafale</legend>
		<div class="flex-between">
		<div>		
			<input type="text" size="3" id="rf_rcl" class="center" placeholder = "Rcl" title="Rcl de l’arme" /> 
			<input type = "text" size="3" id="rf_nbre_balles" class="center" placeholder = "Balles" title="Nombre de balles tirées"/>
			<input type="text" size="3" id="rf_MR" class="center" placeholder = "MR" title="Marge de réussite du tir"/>
			<input type="text" size="3" id="rf_degats" class="center" placeholder="xd±y" title="Dégâts de chaque balle"/>	
		</div>
		<button class="nude" onclick="calcul_rafale()">&#x1F3B2;</button>
		</div>
		</fieldset>
	</form>

</div>

<div>

	<form onsubmit="return false"><!-- Protagonistes -->
		<fieldset><legend>Protagonistes</legend>

		<?php for($i=0 ; $i < $nbre_protagonistes; $i++){ ?>
			<p id="<?= "protagoniste".$i ?>" class="grid gap-½ mt-1" style="grid-template-columns: 1fr 7ch 7ch 7ch">
				<input type="text" size="16" placeholder="Nom" onkeyup="copy_names_in_menus()" title="Entrez ** pour effacer les valeurs">
				<input type="text" size="3" class="center" placeholder="Poids" title="Poids" />
				<input type="text" size="3" class="center" placeholder="PdVm" title="PdV maxi" />
				<input type="text" size="3" class="center" placeholder="PdV" title="PdV actuels" onblur="calculate_cell(this)">
				<input type="text" style="grid-column: 1/span 4" placeholder="Blessures membres" title="Par exemple BD 2, PG 1" />
			</p>
		<?php } ?>

		</fieldset>
	</form>
</div>

<div>
	<form onsubmit="return false"><!-- seuils de blessures -->
		<fieldset><legend>État général (PdV)</legend>
		<div class="flex-between">
			<div>
				<select id="sb_names" style="width: 200px">
					<?php for($i=0 ; $i < $nbre_protagonistes; $i++){ ?>
						<option value="<?= $i ?>">Protagoniste <?= $i+1 ?></option>
					<?php } ?>
				</select>
			</div>
			<button class="nude" onclick="widget_seuils_blessures()">&#x1F3B2;</button><!-- blessures.js -->
		</div>
		</fieldset>
	</form>
	
	<form onsubmit="return false"><!-- effets blessures -->
		<fieldset><legend>Effets d’une blessure</legend>
		<div class="flex-between">
			<div>
				<div>
					<select id="bl_names" style="width: 155px" onfocus="copy_name_in_menus()">
						<?php for($i=0 ; $i < $nbre_protagonistes; $i++){ ?>
							<option value="<?= $i ?>">Protagoniste <?= $i+1 ?></option>
						<?php } ?>
					</select>
					<input type="text" size="3" id="bl_deg_b" class="center" placeholder="xd±y" title="Dégâts bruts" />
					<input type="text" size="3" id="bl_RD" class="center" placeholder="RD" title="RD de la localisation touchée" />
				</div>

				<p>
					<select id="bl_type" style="width: 80px" onchange="unfreeze_bullet_type(this.value)">
						<option value="br" >Broyage</option>
						<option value="tr" selected>Tranchant</option>
						<option value="pe" >Perforant</option>
						<option value="mn" >Mains nues</option>
						<option value="b1" >Balle</option>
						<option value="b0" >Balle (–)</option>
						<option value="b2" >Balle (+)</option>
						<option value="b3" >Balle (++)</option>
						<option value="exp" >Explosion</option>
					</select>
					<select id="bl_type_balle" style="width: 80px" disabled>
						<option value="std">standard</option>
						<option value="bpa">perce-armure</option>
						<option value="bpc">pointe creuse</option>
					</select>
					<select id="bl_localisation" style="width: 80px">
						<option value="alea">Aléatoire</option>
						<option value="torse" selected>Torse</option>
						<option value="coeur">Cœur</option>
						<option value="crane">Crâne</option>
						<option value="visage">Visage</option>
						<option value="cou">Cou</option>
						<option value="jambe">Jambe</option>
						<option value="bras">Bras</option>
						<option value="pied">Pied</option>
						<option value="main">Main</option>
						<option value="oeil">Œil</option>
						<option value="org_gen">Org. génitaux</option>
						<option value="oreille">Oreille</option>
					</select>
				</p>
			</div>
			<button class="nude" onclick="calcul_blessure()">&#x1F3B2;</button> <!-- blessures.js -->
		</div>
		</fieldset>
	</form>

	<form onsubmit="return false"><!-- dégâts objets -->
		<fieldset><legend>Dégâts aux objets (expérimental)</legend>
		<div class="flex-between">
			<div>
				<div>
					<input type="text" size="3" id="do_pdsm" class="center" placeholder="PdSm" title="Pts de structure maxi de l’objet" />
					<input type="text" size="3" id="do_pds" class="center" placeholder="PdS" title="Pts de structure actuels de l’objet" />
					<input type="text" size="3" id="do_integ" class="center" placeholder="Intég." title="Intégrité de l’objet" />
					<input type="text" size="3" id="do_rd" class="center" placeholder="RD" title="RD de l’objet"/>
					<input type="text" size="3" id="do_deg" class="center" placeholder="xd±y" title="Dégâts infligés à l’objet"/>
				</div>
				<p>
					<select id="do_type_deg" style="width: 95px" title = "Type de dégâts">
						<option value="norm">Normaux</option>
						<option value="tr-loc" selected>Localisés</option>
					</select>
					<select id="do_type_objet" style="width: 80px" title = "Type d’objet" >
						<option value="0">&nbsp;---</option>
						<option selected>Voiture</option>
						<option>Moto</option>
						<option>Robot</option>
						<option>Quadricoptère</option>
					</select>

					<select id="do_orientation" style="width: 65px" title="localisation des dégâts" >
						<option>Avant</option>
						<option>Latéral</option>
						<option>Arrière</option>
					</select>

				</p>
			</div>
			<button class="nude" onclick="calcul_degats_objet()">&#x1F3B2;</button>
		</div>
		</fieldset>
	</form>

	<form onsubmit="return false"><!-- collision véhicule -->
		<fieldset><legend>Collision de véhicule (expérimental)</legend>
		<div class="flex-between">
			<div>
				<select id="collision_gravite" style="width: 100px">
					<option value="1">Très Légère</option>
					<option value="2">Légère</option>
					<option value="3">Moyenne</option>
					<option value="4">Grave</option>
					<option value="5">Extrême</option>
				</select>&emsp;
				<input type="text" size="3" id="collision_pdsm" class="center" placeholder="PdSm" />
			</div>
			<button class="nude" onclick="collision()">&#x1F3B2;</button>
		</div>
		</fieldset>
	</form>

	<form onsubmit="return false"><!-- explosion -->
		<fieldset><legend>Explosions</legend>
			<div class="flex-between">
			<div>
			<span style="display: inline-block; width: 40px">Dégâts</span>
				<input type="text" size="5" id="exp_degats" class="center" placeholder="xd±y" title="Dégâts de référence de l’explosion" />
				Distance
				<input type="text" size="3" id="exp_distance" class="center" placeholder = "Dist." title="Distance de la cible" onkeyup="calc_frac_explosion()" />
				<br/>
				<span style="display: inline-block; width: 40px">Blast</span>
				<input type="text" size="5" id="exp_surface_blast" class="center" placeholder = "Surface" title="Surface de la cible (m²)" onkeyup="calc_frac_explosion()" />
				<span style="display: inline-block; width: 37px; text-align: center"><b>ou</b></span>
				<input type="text" size="5" id="exp_%_blast" class="center" placeholder = "%" title="Pourcentage du blast reçu" /> %
				<br/>
				<span style="display: inline-block; width: 40px">Frag.</span>
				<input type="text" size="5" id="exp_surface_frag" class="center" placeholder = "Surface" title="Surface de la cible (m²)" onkeyup="calc_frac_explosion()" />
				<span style="display: inline-block; width: 37px; text-align: center"><b>ou</b></span>
				<input type="text" size="5" id="exp_%_frag" class="center" placeholder = "%" title="Pourcentage des éclats reçus" /> %
				<br/>
				<label for="exp_frag">Nombreux éclats</label>
				<input type="checkbox" id="exp_frag" title="Engin explosif à fragmentation ?" />
			</div>
			<button class="nude" onclick="calcul_deg_explosion()">&#x1F3B2;</button>
			</div>
		</fieldset>
	</form>

</div>

</article>

<article id="chat-container">

	<?php if($_SESSION["Statut"]){ include "chat/chat_display.php";}
	else{ ?>

		<!-- Résultats des widgets en mode hors connexion -->
		<h3 class="mrtop0 center">Affichage des résultats</h3>
		<div id="chat_box"></div>
		<input hidden id="msg-content" />
		<script>
			function send_msg(){
				let chat_box = document.getElementById("chat_box")
				let msg_content = document.getElementById("msg-content")
				let msg = document.createElement("p")
				msg.innerHTML = msg_content.value
				msg_content.value = ""
				chat_box.appendChild(msg)
				chat_box.scrollTop = chat_box.scrollHeight;
			}
		</script>

	<?php ;} ?>

</article>

<script src="fonctions/roll_dices.js"></script>
<script src="fonctions/calculs_degats.js"></script>
<script src="fonctions/blessures_datas.js"></script>
<script src="fonctions/blessures_calculs.js"></script>
<script src="fonctions/degats_objets.js"></script>

<script>

	// active le type de balle si "balle" est sélectionné
	function unfreeze_bullet_type(value){
		let select_bullet = document.getElementById("bl_type_balle")
		if (["b0", "b1", "b2", "b3"].includes(value)) {select_bullet.disabled = false}
		else {
			select_bullet.value = "std"
			select_bullet.disabled = true
		}
	}

	// copie les noms des protagonistes dans le menu déroulant du widget État général
	function copy_names_in_menus(){
		for(let i = 0 ; i < 8 ; i++){
			let nom = get_id("protagoniste" + i).children[0].value
			let liste_noms_seuils_blessures = get_id("sb_names")
			let liste_noms_effets_blessures = get_id("bl_names")
			if(nom !== "" && nom !== "**") {
				liste_noms_seuils_blessures.options[i].innerText = nom
				liste_noms_effets_blessures.options[i].innerText = nom
			}
			else if (nom === "**"){
				get_id("protagoniste" + i).children[0].value = ""
				get_id("protagoniste" + i).children[1].value = ""
				get_id("protagoniste" + i).children[2].value = ""
				get_id("protagoniste" + i).children[3].value = ""
				get_id("protagoniste" + i).children[5].value = ""
				liste_noms_seuils_blessures.options[i].innerText = "Protagoniste" + (i+1)
				liste_noms_effets_blessures.options[i].innerText = "Protagoniste" + (i+1)
			}
			else{
				liste_noms_seuils_blessures.options[i].innerText = "Protagoniste" + (i+1)
				liste_noms_effets_blessures.options[i].innerText = "Protagoniste" + (i+1)
			}
		}
	}

	copy_names_in_menus()
	
</script>