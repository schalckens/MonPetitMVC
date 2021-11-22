<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace APP\Controller;

use APP\Model\GestionCommandeModel;
use APP\Model\GestionClientModel;
use Tools\Repository;
use APP\Repository\CommandeRepository;
use ReflectionClass;
use \Exception;
use Tools\MyTwig;

class GestionCommandeController {

    public function chercheUne($params) {
        //appel de la méthode find($id) de la classe Model adequate
        //$modele = new GestionCommandeModel();
        //$ids = $modele->findIds(); #3
        //$id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
        //$uneCommande = $modele->find($id);
        $repository = Repository::getRepository("APP\Entity\Commande");
        $ids =$repository->findIds();
        $params['lesId'] = $ids;
        if(array_key_exists('id', $params)) {
            $id = filter_var(intval($params['id']), FILTER_VALIDATE_INT);
            $uneCommande = $repository->find($id);
            $params['uneCommande'] = $uneCommande;
        }
        $r = new ReflectionClass($this);
        $vue = str_replace('Controller', 'View', $r->getShortName())."/uneCommande.html.twig";
        MyTwig::afficheVue($vue,$params);
        /*if ($uneCommande) {
            $r = new ReflectionClass($this);
            include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/uneCommande.php";
        } else {
            throw new Exception("commande" . $id . " inconnu");
        }
         * 
         */
    }

    public function chercheToutes() {
        //  appel de la méthode findAll() de la classe Model adequate
        $modele = new GestionCommandeModel();
        $commandes = $modele->findAll();
        if ($commandes) {
            $r = new ReflectionClass($this);
            include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/plusieursCommande.php";
        } else {
            throw new Exception("Aucune Commande à afficher");
        }
    }

    public function commandesUnClient($idClient) {
        $modele = new GestionCommandeModel();
        $modeleClient = new GestionClientModel();
        $commandes = $modele->findAllByIdClient($idClient['id']);
        $client = $modeleClient->find($idClient['id']);
        $r = new ReflectionClass($this);
        $vue = str_replace('Controller', 'View', $r->getShortName()) . "/plusieursCommandeUnclient.html.twig";
        $params = array(
            'commandes' => $commandes,
            'client' => $client
        );
        MyTwig::afficheVue($vue, $params);
    }

}
