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
        //$modele = new GestionClientModel();
        //$id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);#2
        // dans tous les cas on récupère les Ids des clients
        //$ids = $modele->findIds(); #3
        $repository = Repository::getRepository("APP\Entity\Client");
        $ids = $repository->findIds();
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
        $paramsVue['titres'] = $titres;
        $paramsVue['cps'] = $cps;
        $paramsVue['villes'] = $villes;
        if (isset($params['titreCli']) || isset($params['cpCli']) || isset($params['villeCli'])) {
            // c'est le retour du formulaire de choix de filtre
            $element = "Choisir...";
            while (in_array($element, $params)) {
                unset($params[array_search($element, $params)]);
            }
            if (count($params) > 0) {
                $clients = $repository->findBy($params);
                $paramsVue['clients'] = $clients;
                foreach ($_POST as $valeur)
                {
                    ($valeur != "Choisir...") ? ($criteres[] = $valeur) : (null);
                }
                $paramsVue['criteres'] = $criteres;
            }
        }
        $vue = "GestionClientView\\filtreClients.html.twig";
        MyTwig::afficheVue($vue,$paramsVue);
    }
    
    public function recupereDesClients($params) {
        $repository = Repository::getRepository("APP\Entity\Client");
        $clients = $repository->findBy($params);
        $r = new ReflectionClass($this);
        $vue = str_replace('Controller', 'View', $r->getShortName())."/tousClients.html.twig";
        MyTwig::afficheVue($vue, array('clients' => $clients));
    }
    
    public function chercheUnAjax($params): void {
        $repository = Repository::getRepository("APP\Entity\Client");
        $ids = $repository->findIds();
        $params['lesId'] = $ids;
        $r = new ReflectionClass($this);
        
        if (!array_key_exists('id', $params)) {
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName()) . "/unClientAjax.html.twig";
        } else{
            $id = filter_var($params["id"], FILTER_VALIDATE_INT);
            $unObjet = $repository->find($id);
            $params['unClient'] = $unObjet;
            $vue = "blocks/singleClientModif.html.twig";
        }
        MyTwig::afficheVue($vue, $params);
    }
    
    public function modifierClient($params){
        $repository = Repository::getRepository("APP\Entity\Client");
        $id = filter_var($params["id"], FILTER_VALIDATE_INT);
        $client = new Client ($params);
        if (strlen($client->getAdresseRue2Cli()) == 0) {
            $client->setAdresseRue2Cli("_null_");
        }
        $repository->modifieTable($client);
        header("Location:?c=GestionClient&a=chercheTous");
    }
    
    public function rechercheClientsAjax($params){
        $repository = Repository::getRepository("APP\Entity\Client");
        
        if (empty($params['titreCli']) && empty($params['cpCli']) || empty($params['villeCli'])) {
            $titres = $repository->findColumnDistinctValues('titreCli');
            $cps = $repository->findColumnDistinctValues('cpCli');
            $villes = $repository->findColumnDistinctValues('villeCli');
            $paramsVue['titres'] = $titres;
            $paramsVue['cps'] = $cps;
            $paramsVue['villes'] = $villes;
            $vue = "GestionClientView\\filtresClientsAjax.html.twig";
        } else {
            // c'est le retour du formulaire de choix de filtre
            $element = "Choisir...";
            while (in_array($element, $params)) {
                unset($params[array_search($element, $params)]);
            }
            if (count($params) > 0) {
                $clients = $repository->findBy($params);
                $paramsVue['clients'] = $clients;
                $vue = "blocks/arrayClients.html.twig";
            }
        }
        MyTwig::afficheVue($vue,$paramsVue);
    }
    
    public function statsClients(){
        $repository = new ClientRepository("APP\Entity\Client");
        $rawData = $repository->statistiquesTousClients();
        $nomCol = array_column($rawData, 'nom');
        $nbComCol = array_column($rawData, 'nbcom');
        array_multisort($nbComCol,SORT_DESC, $nomCol, SORT_ASC, $rawData);
        if($rawData) {
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName())."/statsClients.html.twig";
            MyTwig::afficheVue($vue, array('stats' => $rawData));
        } else {
            throw new Exception("Aucun Client à afficher");
        }
    }
}
