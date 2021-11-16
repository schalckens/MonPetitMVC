<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace APP\Controller;

use APP\Model\GestionClientModel;
use ReflectionClass;
use \Exception;
use Tools\MyTwig;

class GestionClientController {
    
    public function chercheUn($params) {
        //appel de la méthode find($id) de la classe Model adequate
        $modele = new GestionClientModel();
        //$id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);#2
        // dans tous les cas on récupère les Ids des clients
        $ids = $modele->findIds();
        $params['lesId'] = $ids;
        if (array_key_exists('id', $params)) {
            $id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
            $unClient = $modele->find($id);
            // on place le client trouvé dans le tableau de paramètres que l'on va envoyer à la vue
            $params['unClient'] = $unClient;
        }
        $r = new ReflectionClass($this);
        $vue = str_replace('Controller', 'View', $r->getShortName())."/unClient.html.twig";
        MyTwig::afficheVue($vue,$params);
        /* 
        $unClient = $modele->find($id);
        if($unClient) {
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName())."/unClient.html.twig";
            MyTwig::afficheVue($vue, array('unClient' => $unClient));
            // include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName())."/unClient.php"; #1
        } else {
            throw new Exception("client".$id." inconnu");
        }
         * #2
         */
    }
    
    public function chercheTous() {
        //  appel de la méthode findAll() de la classe Model adequate
        $modele = new GestionClientModel();
        $clients = $modele->findAll();
        if($clients) {
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName())."/tousClients.html.twig";
            MyTwig::afficheVue($vue, array('clients' => $clients));
            //include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/plusieursClients.php";
        } else {
            throw new Exception("Aucun Client à afficher");
        }
    }
    
    public function creerClient($params) {
        $vue = "GestionClientView\\creerClient.html.twig";
        MyTwig::afficheVue($vue, array());
    }
    
    public function enregistreClient($params) {
        //création de l'objet client
        $client = new Client($params);
        $modele = new GestionClientModel();
        $modele->enregistreClient($client);
    }
}
