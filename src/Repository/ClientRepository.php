<?php

namespace APP\Repository;

use Tools\Repository;

class ClientRepository extends Repository {
    
    public function __construct($entity) {
        parent::__construct($entity);
    }
    
    public function statistiquesTousClients(){
        $sql = "select client.id as id, client.nomCli as nom, client.prenomCli as prenom,"
                . " client.villeCli as ville, count(commande.Id) as nbcom"
                . " from client left join commande on client.id = commande.idClient"
                . " group by client.id;";
        return $this->executeSQL($sql);
    }
}
