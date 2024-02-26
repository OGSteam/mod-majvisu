<?php
if (!defined('IN_SPYOGAME')) {
	exit('Hacking attempt!');
}




function isModuleActive() {
    global $db;
    $query = 'SELECT active FROM ' . TABLE_MOD . ' WHERE action = \'majvisu\' AND active = \'1\' LIMIT 1';
    return $db->sql_numrows($db->sql_query($query)) > 0;
}


function initializeUniverse( $g , $s ) {
    $universe = [];
    for ($i = 1; $i < $g +1 ; $i++) {
        for ($j = 1; $j <  $s + 1 ; $j++) {
            $universe[$i][$j] = 'u';
        }
    }
    return $universe;
}


function updateUniverse( $universe, $t) {
    global $db;
    $result = $db->sql_query('SELECT last_update, galaxy, system FROM ' . TABLE_UNIVERSE . ' WHERE row = 1 ORDER BY galaxy, system');
    while (list($last_update, $galaxy, $system) = $db->sql_fetch_row($result)) {
        foreach ($t as $index => $time) {
            if ($last_update > $time) {
                $universe[$galaxy][$system] = $index + 1;
                break;
            }
        }
    }
    return $universe;
}


function generateTable($universe, $nb_g, $nb_s) {
    echo '<table class="og-table og-medium-table mv-table ">';
    echo '<tr><td></td>';
    for ($i = 0; $i < $nb_g + 1 ; $i++) {
        echo '<td colspan="51">' . ($i * 50) . ' - ' . (($i + 1) * 50) . '</td>';
    }
    echo '</tr>';

    for ($g = 1; $g < $nb_g + 1; $g++) {
        echo '<tr><th class="mv-table-cell">G' . $g . '</td>';
        for ($s = 1; $s < $nb_s + 1 ; $s++) {
            $GSMessage = $universe[$g][$s] > 3 ? '" onmouseover="document.getElementById(\'CurrentMouseOver\').innerHTML=\'Dernier système non rafraichi survolé : ' . $g . ':' . $s . '\';' : '';
            echo '<td class="mv-jour-' . $universe[$g][$s] . $GSMessage . '"></td>';
            if ($s % 50 == 0) {
                echo '<td class="mv-space"></td>';
            }
        }
        echo '</tr>';
    }

    echo '</table>';
}

function generateLegend($nb_jour) {
    $colors = generateColorVariation($nb_jour+1);
    echo '<table class="og-table og-little-table mv-legend">';
    echo '<tbody><tr><td colspan="2"><span class="og-highlight"><div id="CurrentMouseOver">&nbsp;</div></span></td></tr></tbody>';
    echo '<thead><tr><th colspan="2">Legende</th></tr></thead>';
    echo '<tbody>';
    for ($i = 1; $i < $nb_jour + 1 ; $i++) {
        echo '<tr><td class="mv-color mv-jour-' .  $i . '"></td>';
        echo '<td class="mv-legend-cell">' . 'moins de ' . $i . ' jour' . ($i == 1 ? '' : 's') . '</td></tr>';
    }

    echo '<tr><td class="mv-color mv-jour-u"></td>';
    echo '<td class="mv-legend-cell">jamais scanné ou supérieur </td></tr>';

    echo '</tbody></table>';
}



//chat gpt
function generateColorVariation($n) {
    $colors = array();
    // Définir les composantes de couleur initiales et finales (vert à rouge)
    $startColor = array(0, 255, 0); // Vert
    $endColor = array(0, 36, 0);   // Rouge
    
    // Calculer la variation pour chaque composante de couleur
    $rStep = ($endColor[0] - $startColor[0]) / ($n - 1);
    $gStep = ($endColor[1] - $startColor[1]) / ($n - 1);
    $bStep = ($endColor[2] - $startColor[2]) / ($n - 1);
    
    // Générer les couleurs pour chaque élément
    for ($i = 0; $i < $n; $i++) {
        $r = round($startColor[0] + $i * $rStep);
        $g = round($startColor[1] + $i * $gStep);
        $b = round($startColor[2] + $i * $bStep);
        $color = sprintf("#%02x%02x%02x", $r, $g, $b);
        $colors[$i] = $color;
    }
    
    return $colors;
}