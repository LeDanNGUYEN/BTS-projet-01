<?php
require_once ("connect.php");

// FONCTIONS GET : getInstrument, getLesCours, getListInscription --------------------------------------------------

function getLesInstruments(){ // Pas utilisée
    $req = "SELECT * FROM instrument";

    $rep = connectBdd()->prepare($req);
    $rep->execute();
    $tab_instruments = $rep->fetchAll();
    return $tab_instruments;
}

function getLesCours(){
    $req = "SELECT * FROM cours
        INNER JOIN professeur ON cours.idProfesseur = professeur.professeur_id 
        INNER JOIN instrument ON cours.idInstrument = instrument.instrument_id 
        ORDER BY cours_id";

    $rep = connectBdd()->prepare($req);
    $rep->execute();
    $tab_cours = $rep->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($tab_cours);
    return $tab_cours;
}

function getLastAdherentUpdated($tableauInscription){

    $bdd = connectBdd();
    // REQUETE SPECIALE ICI : sélectionne le dernier client modifié suivant le nom et prenom,
    // et suivant le nombre de résultats trouvés, prend le dernier
    // AUTRE RQ : requete en 2 temps CAR sinon j'obtiens un tableau qui contient un tableau qui a l'info ID...
    $req_getAdh = $bdd->prepare("SELECT adherent_id FROM adherent WHERE nom = ? AND prenom = ?");
    $nom_cherche = $tableauInscription[0];
    $prenom_cherche = $tableauInscription[1];
    $req_getAdh->bindParam(1, $nom_cherche, PDO::PARAM_STR);
    $req_getAdh->bindParam(2, $prenom_cherche, PDO::PARAM_STR);
    $req_getAdh->execute();

    $result_getAdh = $req_getAdh->fetchAll(PDO::FETCH_ASSOC);
    $lastAdh_id = $result_getAdh[count($result_getAdh)-1];

    return $lastAdh_id;
}

function getListInscription(){

    // REMARQUE : ajouter un ORDER BY pour trier par ordre chronologique

    $req = "SELECT c.horaire, c.nbPlace, 
                    i.instrument_nom, 
                    p.prof_nom, p.prof_prenom, 
                    a.nom, a.prenom, a.adherent_id, c.cours_id
                    FROM inscription AS inst 
                    INNER JOIN cours AS c ON c.cours_id = inst.idCours 
                    INNER JOIN professeur AS p ON p.professeur_id = c.idProfesseur 
                    INNER JOIN instrument AS i ON i.instrument_id = c.idInstrument 
                    INNER JOIN adherent AS a ON a.adherent_id = inst.idAdherent";

    $rep = connectBdd()->prepare($req);
    $rep->execute();
    $tab_cours = $rep->fetchAll(PDO::FETCH_ASSOC);
    return $tab_cours;
}

function checkNombrePlace($idCours){
    $bdd = connectBdd();
    $req_check_nbPlace = $bdd->prepare("SELECT COUNT(*) AS nombre FROM cours WHERE cours_id = ?");
    $req_check_nbPlace->bindParam(1,$idCours,PDO::PARAM_INT);

    if( !$req_check_nbPlace->execute() ){
        return -1;
    }
    $result = $req_check_nbPlace->fetch(PDO::FETCH_ASSOC);

    return $result['nombre'];
}

function getListInscriptionAdh($adherent_id_inscrit){
    
    $req = "SELECT c.horaire, c.nbPlace, 
                    i.instrument_nom, 
                    p.prof_nom, p.prof_prenom, 
                    a.nom, a.prenom, a.adherent_id, c.cours_id
                    FROM inscription AS inst 
                    INNER JOIN cours AS c ON c.cours_id = inst.idCours 
                    INNER JOIN professeur AS p ON p.professeur_id = c.idProfesseur 
                    INNER JOIN instrument AS i ON i.instrument_id = c.idInstrument 
                    INNER JOIN adherent AS a ON a.adherent_id = inst.idAdherent
                    WHERE a.adherent_id = ?";

    $rep = connectBdd()->prepare($req);
    $rep->bindParam(1,$adherent_id_inscrit,PDO::PARAM_INT);
    $rep->execute();
    $tab_cours_adh = $rep->fetchAll(PDO::FETCH_ASSOC);
    return $tab_cours_adh;
}

function checkIfAdherentDejaInscritAuCours($idCours, $idAdherent){

    $bdd = connectBdd();
    $req_comptage = $bdd->prepare("SELECT COUNT(*) AS nombre FROM inscription WHERE idAdherent = ? AND idCours = ?");
    $req_comptage->execute([ $idAdherent, $idCours ]);
    $result = $req_comptage->fetch(PDO::FETCH_ASSOC);
    
    if($result['nombre']>=1){
        return true;
    }
    return false;
}

function getAdherent($adh_mail, $adh_mdp){

    $bdd = connectBdd();
    $req_get_adh = $bdd->prepare("SELECT * FROM adherent WHERE mail = ? AND mdp = ?");
    if( !$req_get_adh->execute([$adh_mail, $adh_mdp]) ){
        return false;
    }
    return $info_adh = $req_get_adh->fetchAll(PDO::FETCH_ASSOC);
}

function getAdherent2($adh_mail, $adh_mdp){
    try{
        $bdd = connectBdd();
        $req_get_adh = $bdd->prepare("SELECT * FROM adherent WHERE mail = ? AND mdp = ?");
        $req_get_adh->execute([$adh_mail, $adh_mdp]);
        return $info_adh = $req_get_adh->fetchAll(PDO::FETCH_ASSOC);

    }catch(Exception $e){
        echo $e->getMessage();
    }
}

function getAdherent3($adh_mail, $adh_mdp){
    try{
        $bdd = connectBdd();
        $req_get_adh = $bdd->prepare("SELECT * FROM adherent WHERE mail = ? AND mdp = ?");
        if( !$req_get_adh->execute([$adh_mail, $adh_mdp]) ){
            return false;
        }
        return $req_get_adh->fetchAll(PDO::FETCH_ASSOC);

    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
}

function getAdherent4($adh_id){
    try{
        $bdd = connectBdd();
        $req_get_adh = $bdd->prepare("SELECT * FROM adherent WHERE adherent_id = ?");
        if( !$req_get_adh->execute([$adh_id]) ){
            return false;
        }

        return $req_get_adh->fetchAll(PDO::FETCH_ASSOC);

    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
}

// FONCTIONS Modification BDD : inscriptionAdherent, updateNombreCours --------------------------------------------------

function inscriptionAdherent3($tableauInscription){

    $bdd = connectBdd();
    $req_inscription = $bdd->prepare("INSERT INTO adherent(nom,prenom,tel,adresse,mail,mdp) 
                            VALUES(?, ?, ?, ?, ?, ?)");
    $reponse = $req_inscription->execute([$tableauInscription[0], $tableauInscription[1], $tableauInscription[2], 
                    $tableauInscription[3], $tableauInscription[4], $tableauInscription[5]]);

    if($reponse == false){
        return false;
    }
    
    $req_inscription = null;
    return true;
}

function updateNombreCours_decrease($tableauInscription){
    $bdd = connectBdd();

    $req_updateNbPlace = $bdd->prepare("UPDATE cours SET nbPlace = nbPlace - 1 WHERE cours_id = ?");
    $reponse = $req_updateNbPlace->execute([$tableauInscription[6]]);

    if($reponse == null){
        return false;
    }
    
    $req_updateNbPlace = null;
    return true;
}

function updateNombreCours_increase($tableauInscription){
    $bdd = connectBdd();

    $req_updateNbPlace = $bdd->prepare("UPDATE cours SET nbPlace = nbPlace + 1 WHERE cours_id = ?");
    $req_updateNbPlace->execute([$tableauInscription[6]]);

    if($req_updateNbPlace == null){
        return false;
    }
    
    $req_updateNbPlace = null;
    return true;
}

function updateNombreCours_increase2($idCours){
    $bdd = connectBdd();

    $req_updateNbPlace = $bdd->prepare("UPDATE cours SET nbPlace = nbPlace + 1 WHERE cours_id = ?");
    $req_updateNbPlace->execute([$idCours]);

    if($req_updateNbPlace == null){
        return false;
    }
    
    $req_updateNbPlace = null;
    return true;
}

function updateInscription_add($tableauInscription, $numAdherentInscrit){

    $bdd = connectBdd();

    if(checkIfAdherentDejaInscritAuCours($tableauInscription[6], $numAdherentInscrit["adherent_id"]) == true){
        // echo "DEJA INSCRIT NON";
        return false;
    }else{
        $req_updateNbPlace = $bdd->prepare("INSERT INTO inscription (idAdherent, idCours, paye) VALUES (?, ?, 0)");
        $req_updateNbPlace->execute([$numAdherentInscrit["adherent_id"], $tableauInscription[6]]);
        if($req_updateNbPlace == null){
            // echo "REQUETE NON";
            return false;
        }
        $req_updateNbPlace = null;
        // echo "REQUETE OK";
        return true;
    }
}

function updateInscription_supprimer($idAdherent, $idCours){

    $bdd = connectBdd();

    $req_updateInsc = $bdd->prepare("DELETE FROM inscription WHERE idAdherent = ? AND idCours = ?");
    $req_updateInsc->execute([ $idAdherent, $idCours ]);

    if($req_updateInsc == null){
        return false;
    }

    $req_updateInsc = null;
    return true;
}

// CHECK pour connexion ----------------------------------------------------------------------------------------

function end_session(){
    session_unset();
    session_destroy();
}

























