<?php

if (!defined('IN_SPYOGAME')) {
	exit('Hacking attempt!');
}

// ajout modif inter
define('FOLDER_LANG', 'mod/majvisu/lang');
include_once FOLDER_LANG . '/lang_french.php';

// récuperation des g max et ss max
$nb_g = (int)$server_config['num_of_galaxies'];
$nb_s = (int)$server_config['num_of_systems'];
$nb_jour = 10;

require_once 'views/page_header.php';
require_once 'mod/majvisu/functions.php';


// Vérifier si le module est activé
if (!isModuleActive()) {
	exit('Mod non activé!');
	die();
}
//choix du nombre de jour
if (isset($pub_nbjour)) {
	$pub_nbjour = (int)$pub_nbjour;
	$nb_jour = ($pub_nbjour < 100 ) ? $pub_nbjour : $nb_jour ;
}

// import du style ici car depend de $nb_jour
require_once 'mod/majvisu/style.css.php';

?>
<div class="ogspy-mod-header">
	<h2>Mise à Jour Visuelle</h2>
</div>


<table class="og-table og-small-table">
	<form method="POST" action="index.php">
	<input type="hidden" name="action" value="majvisu">

	<tbody>
		<form action="index.php?action=majvisu" method="post" name="form">
		<tr>
			<td>
				<label>Nombre de jour</label>
			</td>
			<td>
				<input type="text" style="width: 20px;" value="<?php echo $nb_jour; ?>" name="nbjour">
			</td>
			<td>
				<input class="og-button" type="submit" value="Valider">
			</td>
		</tr>
	</tbody>
	</form>
</table>


<?php


// Initialiser le tableau univers
$universe = initializeUniverse($nb_g, $nb_s);



// Créer un tableau de temps
$t = [];
for ($i = 1; $i < $nb_jour; $i++) {
	$t[] = time() - $i * 24 * 3600;
}




// Mettre à jour le tableau univers avec les dates de mise à jour
$universe = updateUniverse($universe, $t);

// Générer le tableau HTML de visualisation des mises à jour de l'univers
generateTable($universe, $nb_g, $nb_s);


// Générer la légende du tableau HTML
generateLegend($nb_jour);


?>

<div class="ogspy-mod-footer">
	<p> Module de visualisation des mises à jour de l univers par <i>Machine</i></p>
</div>

<?php require_once 'views/page_tail.php'; ?>