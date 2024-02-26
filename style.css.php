<?php
if (!defined('IN_SPYOGAME')) {
    exit('Hacking attempt!');
}
?>
<style type="text/css">
    .mv-table,
    .mv-legend {
        border-collapse: collapse;
    }

    .mv-table td,
    .mv-legend td {
        color: white;
        font-weight: bold;
    }

    .mv-legend {
        width: 985px;
    }

    .mv-table td {
        width: 0.5em;
        height: 30px;
        text-align: center;
    }

    .mv-legend tr {
        height: 20px;
    }

    .mv-color {
        width: 50px;
    }

    .mv-legend-cell {
        padding-left: 10px;
    }

    .mv-table-cell {
        padding-right: 15px;
    }

    .mv-space {
        padding: 0px;
        width: 1px;
    }


    .mv-jour-u{
        background-color: black!important;
        padding: 0px;
    }

    <?php $colors = generateColorVariation($nb_jour+1);; ?>

    <?php for ($i = 0; $i < $nb_jour + 1; $i++) : ?>
    .mv-jour-<?php echo $i;?>  {
        <?php if (isset($colors[$i])) :?>
      background-color: <?php echo $colors[$i];?>!important;; 
            <?php else :?>
                background-color:<?php echo $colors[$nb_jour];?>; 
          <?php endif;?>
  
        padding: 0px;
    }

    <?php endfor; ?>
</style>