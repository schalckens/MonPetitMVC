<?php

namespace APP\Repository;

use Tools\Repository;
use Tools\Connexion;
use APP\Entity\Commande;
use PDO;

class CommandeRepository extends Repository {
    
    public function __construct($entity) {
        parent::__construct($entity);
    }
    
    public function findAllByIdClient($idClient){
        $unObjetPdo = $this->connexion;
        $sql = "select * from COMMANDE where idClient = :idClient";
        $lignes = $unObjetPdo->prepare($sql);
        $lignes->bindValue(':idClient',$idClient, PDO::PARAM_INT);
        $lignes->execute();
        return $lignes->fetchAll(PDO::FETCH_CLASS, Commande::class);
    }
}
