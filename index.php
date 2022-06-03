<?php

    session_start();

    // REQUIRE ONCE - INCLUDE pour tout
    require_once("modele/fonction.php");
    require_once ("modele/connect.php");

    // var_dump($_POST);
    // var_dump($_SESSION);

    // Modification variable $action
    if(!isset($_REQUEST['action'])){
        $action = 'accueil';
    } else {
        $action = $_REQUEST['action'];
    }

    // Modification variable $coursSelectionne
    if(!isset($_REQUEST['coursSelectionne'])){
        $coursSelectionne = "";
    } else {
        $coursSelectionne = $_REQUEST['coursSelectionne'];
    }

    // Check si inscription ET inscription cours (donc nombrePlace -1 et table Inscription Update)
    // A FAIRE : vérifier s'il y a des places. Si non prévenir. 
    if(!isset($_POST["submit"])){

    }else{
        $nom = htmlspecialchars($_POST["join_nom"] ? $_POST["join_nom"] : '');
        $prenom = htmlspecialchars($_POST["join_prenom"] ? $_POST["join_prenom"] : '');
        $tel = htmlspecialchars($_POST["join_tel"] ? $_POST["join_tel"] : '');
        $adresse = htmlspecialchars($_POST["join_adresse"] ? $_POST["join_adresse"] : '');
        $mail = htmlspecialchars($_POST["join_mail"] ? $_POST["join_mail"] : '');
        $mdp = htmlspecialchars($_POST["join_mdp"] ? $_POST["join_mdp"] : '');
        $mdprepeat = htmlspecialchars($_POST["join_mdprepeat"] ? $_POST["join_mdprepeat"] : '');
        $idCours = htmlspecialchars($_POST["cours_choix"] ? $_POST["cours_choix"] : '');

        $tableauInscription = [$nom,$prenom,$tel,$adresse,$mail,$mdp,$idCours];

        $nombrePlacesRestantesCours = checkNombrePlace($idCours); // TEST s'il reste des places
        if($nombrePlacesRestantesCours<=0){
            // MESSAGE A FAIRE : pour dire qu'il n'y a plus de place
        }else{

            if(!inscriptionAdherent3($tableauInscription)){ // MODIFICATION - rentrée d'un nouvel utilisateur dans table adherent OU PAS avec déclencheur dans la BDD fait
                // echo "NO1-----------------------------------------NO1";
            }else{
                // echo "YES1-----------------------------------------YES1";
                $numAdherentInscrit = getLastAdherentUpdated($tableauInscription); // ICI je prends le numéro adhérent ajouté/modifié
                //var_dump($numAdherentInscrit);
                if(!updateInscription_add($tableauInscription, $numAdherentInscrit)){ // MODIFICATION - table INSCRIPTION modifiée
                    // echo "NO2-----------------------------------------NO2";
                }else{
                    // echo "YES2-----------------------------------------YES2";
                    // var_dump($tableauInscription);
                    // var_dump($numAdherentInscrit);
                    updateNombreCours_decrease($tableauInscription); // MODIFICATION - Update du nombre de place dans le cours
                    //$listeDesCoursPourCetAdh = getListInscriptionAdh($numAdherentInscrit); // Reception des infos d'inscriptions pour l'adh
                }
            }

        }

    }

    // Check si SUPPRIMER INSCRIPTION et si oui on supprime
    if(isset($_POST["suppression_inscription"])){
        $idAdherent = htmlspecialchars($_POST["id_adherent"]?$_POST["id_adherent"]:"");
        $idCours = htmlspecialchars($_POST["id_cours"]?$_POST["id_cours"]:"");
        var_dump($_POST);
        if(!updateInscription_supprimer($idAdherent, $idCours)){
            echo "ERREUR - suppression annnulée";
        } else {
            echo "Suppression en cours - vérifiez";
            if(!updateNombreCours_increase2($idCours)){
                echo "ERREUR - nombre de place pas mis à jour";
            }else{
                echo "Rajout d'une place pour le cours";
            }
        }
        $action = 'voirListeInscription';
    }

    // CHECK si connexion ET tentative connexion
    if(isset($_POST["connexion_adh"])){
        $adh_mail = htmlspecialchars($_POST["connect_mail"]?$_POST["connect_mail"]:"");
        $adh_mdp = htmlspecialchars($_POST["connect_mdp"]?$_POST["connect_mdp"]:"");

        $info_adh = getAdherent3($adh_mail, $adh_mdp);
        if($info_adh == false){
            echo "ERREUR - pas d'adherent trouvé";
            $action = 'voirConnexion';
        } else {
            // echo "yo ya des infos !";
            $_SESSION["est_connecte"] = "user_connected";
            $_SESSION["id_user"] = $info_adh[0]["adherent_id"];
            $_SESSION["user_info"] = $info_adh[0];
            // var_dump($info_adh);
            // var_dump($_SESSION);
            $action = 'accueil';
        }

        // try{
        //     $info_adh = getAdherent2($adh_mail, $adh_mdp);
        //     echo "YOYOYO je suis dans le TRY";
        //     var_dump($info_adh);
        // }catch(Exception $e){
        //     echo "ERREUR lors de la connexion avec ces identifiants".$e->getMessage();
        // }
    }
    
    // CORPS SITE -----------------------------------------------------------------------

    // Vue - EN-TETE
    include("vues/v_header.php");

    // Vue - update suivant $action
    switch($action){
        case 'accueil':
            include("vues/v_body_accueil.php");
            break;

        case 'voirCours':
            // NOTE : ici partie de connexion à la BDD
            // A mettre AVANT le html du body pour avoir acès aux données !
            $bdd = connectBdd();
            // $tabInstruments = getLesInstruments();
            $tabCours = getLesCours();
            include("vues/v_body_cours.php");
            break;

        case 'voirInscription':
            $listCours = getLesCours();
            $selected[$coursSelectionne] = 'selected="selected"'; // $coursSelectionne dans l'index
            include("vues/v_body_inscription.php");
            break;
        
        case 'voirConnexion':
            include("vues/v_body_connexion.php");
            break;

        case 'voirListeInscription':
            $bdd = connectBdd();
            // $tabInstruments = getLesInstruments();
            // $tabCours = getLesCours();
            $tabInscription = getListInscription();
            // var_dump($tabInscription);
            include("vues/v_body_list_inscription.php");
            break;

        case 'adhDeconnexion':
            end_session();
            // echo "DECONNEXION ICI !!!";
            // var_dump($_SESSION);
            header("Location: index.php");
            break;

        default : 
            include("vues/v_body_accueil.php");
    }


    // Vue - Pied de Page
    include("vues/v_footer.php");

    // $tableauInscription2 = ['test2','test2','0102030405','02 rue des tests','test@fakemail.com','test','1'];
    // var_dump(getLastAdherentUpdated($tableauInscription2));
    // $idCoursTest = 1;
    // $result = checkNombrePlace($idCoursTest);
    // echo $result;
    // $adherent_id_inscrit = 46;
    // $listeDesCoursPourCetAdh = getListInscriptionAdh($adherent_id_inscrit);
    // var_dump($listeDesCoursPourCetAdh);
    // $numAdherentInscrit = 49;
    // $tableauInscription2 = ['test2','test2','0102030405','02 rue des tests','test@fakemail.com','test','4'];
    // checkIfAdherentDejaInscritAuCours($tableauInscription2[6], $numAdherentInscrit);
    // updateInscription_add($tableauInscription2, $numAdherentInscrit);
  
    // $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
?>

