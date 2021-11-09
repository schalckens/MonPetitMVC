<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include_once PATH_VIEW . "header.html";
echo "<p>Nombre de commandes trouvées : " . count($commandes) . "</p>";

foreach ($commandes as $commande) {
    $facture = $commande->getNoFacture();
    if($facture == null){
        $facture = "Non facturée";
    }
    echo $commande->getId() . " - " . $commande->getDateCde() . " - " . $facture . " - " . $commande->getIdClient() . "<br>";
}
//include_once PATH_VIEW . "footer.html";