<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace APP\Controller;

use APP\Model\GestionCommandeModel;
use ReflectionClass;
use \Exception;

class GestionCommandeController {
    
    public function chercheUne($params) {
        //appel de la méthode find($id) de la classe Model adequate
        $modele = new GestionCommandeModel();
        $id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
        $uneCommande = $modele->find($id);
        if($uneCommande) {
            $r = new ReflectionClass($this);
            include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName())."/uneCommande.php";
        } else {
            throw new Exception("commande".$id." inconnu");
        }
    }
    
    public function chercheToutes() {
        //  appel de la méthode findAll() de la classe Model adequate
        $modele = new GestionCommandeModel();
        $commandes = $modele->findAll();
        if($commandes) {
            $r = new ReflectionClass($this);
            include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/plusieursCommande.php";
        } else {
            throw new Exception("Aucune Commande à afficher");
        }
    }
}