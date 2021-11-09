<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include_once PATH_VIEW . "header.html";
echo "<p>Nombre de clients trouvés : " . count($clients) . "</p>";

foreach ($clients as $client) {
    echo $client->getId() . " " . $client->getTitreCli() . " " . $client->getPrenomCli() . " " . $client->getNomCli() . "<br>";
}
//include_once PATH_VIEW . "footer.html";