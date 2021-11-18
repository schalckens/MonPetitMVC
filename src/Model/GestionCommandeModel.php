<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace APP\Model;

use \PDO;
use APP\Entity\Commande;
use Tools\Connexion;

class GestionCommandeModel {
    
    public function find($id) {
        $unObjetPdo = Connexion::getConnexion();
        $sql = "select * from COMMANDE where id = :id";
        $ligne = $unObjetPdo->prepare($sql);
        $ligne->bindValue(':id',$id, PDO::PARAM_INT);
        $ligne->execute();
        return $ligne->fetchObject(Commande::class);
    }
    
    public function findAll() {
        $unObjetPdo = Connexion::getConnexion();
        $sql = "select * from COMMANDE";
        $lignes = $unObjetPdo->query($sql);
        return $lignes->fetchAll(PDO::FETCH_CLASS, Commande::class);
    }
    
    public function findAllByIdClient($idClient){
        $unObjetPdo = Connexion::getConnexion();
        $sql = "select * from COMMANDE where idClient = :idClient";
        $lignes = $unObjetPdo->prepare($sql);
        $lignes->bindValue(':idClient',$idClient, PDO::PARAM_INT);
        $lignes->execute();
        return $lignes->fetchAll(PDO::FETCH_CLASS, Commande::class);
    }
}