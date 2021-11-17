<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace APP\Controller;

use APP\Model\GestionClientModel;
use APP\Entity\Client;
use ReflectionClass;
use \Exception;
use Tools\MyTwig;
use Tools\Repository;
use APP\Repository\ClientRepository;

class GestionClientController {
    
    public function chercheUn($params) {
        //appel de la méthode find($id) de la classe Model adequate
        $modele = new GestionClientModel();
        //$id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);#2
        // dans tous les cas on récupère les Ids des clients
        $ids = $modele->findIds(); #3
        $repository = Repository::getRepository("APP\Entity\Client");
        $id = $repository->findIds();
        $params['lesId'] = $ids;
        if (array_key_exists('id', $params)) {
            $id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
            $unClient = $repository->find($id);
            //$unClient = $modele->find($id); #3
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
        //$modele = new GestionClientModel(); #3
        //$clients = $modele->findAll(); #3
        $repository = Repository::getRepository("APP\Entity\Client");
        $clients = $repository->findAll();
        if($clients) {
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName())."/tousClients.html.twig";
            MyTwig::afficheVue($vue, array('clients' => $clients));
            //include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/plusieursClients.php"; #1
        } else {
            throw new Exception("Aucun Client à afficher");
        }
    }
    
    public function creerClient($params) {
        if(empty($params)){
            $vue = "GestionClientView\\creerClient.html.twig";
            MyTwig::afficheVue($vue, array());
        } else {
            //création de l'objet client
            $client = new Client($params);
            $repository = Repository::getRepository("APP\Entity\Client");
            $repository->insert($client);
            $this->chercheTous();
            
            /*
            $params = filter_var_array($params);
            $this->enregistreClient($params);
            $this->chercheTous(); 
             * #3
             */
            
        }
    }
    
    public function enregistreClient($params) {
        //création de l'objet client
        $client = new Client($params);
        $modele = new GestionClientModel();
        $modele->enregistreClient($client);
    }
    
    public function nbClients($params) {
        $repository = Repository::getRepository("APP\Entity\Client");
        $nbClients = $repository->countRows();
        echo "Nombre de clients : " . $nbClients;
    }
    
    public function testFindBy($params) {
        $repository = Repository::getRepository("APP\Entity\Client");
        //$params = array("titreCli" => "Monsieur", "villeCli" => "Toulon");
        //$clients = $repository->findBytitreCli_and_villeCli($params);
        $params = array("cpli" => "14000", "titreCli" => "Madame");
        $clients = $repository->findBycpCli_and_titreCLi($params);
        $r = new ReflectionClass($this);
        $vue = str_replace('Controller', 'View', $r->getShortName()) . "/tousClients.html.twig";
        MyTwig::afficheVue($vue, array('clients' => $clients));
    }
    
    public function rechercheClients($params) {
        $repository = Repository::getRepository("APP\Entity\Client");
        $titres = $repository->findColumnDistinctValues('titreCli');
        $cps = $repository->findColumnDistinctValues('cpCli');
        $villes = $repository->findColumnDistinctValues('villeCli');
        $params['titres'] = $titres;
        $params['cps'] = $cps;
        $params['villes'] = $villes;
        $vue = "GestionClientVIew";
    }
}
