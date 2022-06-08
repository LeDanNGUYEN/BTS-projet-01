<?php

    session_start();

//// ---------------------------------------------------------------------------------------------------------
//// PARTIE CALCUL -------------------------------------------------------------------------------------------

// REQUIRE ONCE - INCLUDE pour tout --------------------------------------------------------------------------
    require_once("modele/fonction.php");
    require_once ("modele/connect.php");

// Modification variable $action -----------------------------------------------------------------------------
    if(!isset($_REQUEST['action'])){
        $action = 'accueil';
    } else {
        $action = $_REQUEST['action'];
    }

// Modification variable $coursSelectionne -----------------------------------------------------------------------------
    if(!isset($_REQUEST['coursSelectionne'])){
        $coursSelectionne = "";
    } else {
        $coursSelectionne = $_REQUEST['coursSelectionne'];
    }

// Check si inscription possible et si oui inscription -------------------------------------------------------------------------
    // inscription cours (donc nombrePlace -1 et table Inscription Update)
    if(!isset($_POST["submit"]))
    {

    } 
    else 
    {       
        // Si je suis déjà connecté
        if( isset($_SESSION["est_connecte"]) and $_SESSION["est_connecte"] == "user_connected")
        {

            $idCours = htmlspecialchars(isset($_POST["cours_choix"]) ? $_POST["cours_choix"] : '');
            $nom = $_SESSION["user_info"]['nom'];
            $prenom = $_SESSION["user_info"]['prenom'];
            $tel = $_SESSION["user_info"]['tel'];
            $adresse = $_SESSION["user_info"]['adresse'];
            $mail = $_SESSION["user_info"]['mail'];
            $mdp = $_SESSION["user_info"]['mdp'];

            $numAdherentInscrit = array("adherent_id" => $_SESSION["user_info"]['adherent_id']);

            $tableauInscription = [$nom,$prenom,$tel,$adresse,$mail,$mdp,$idCours];
    
            $nombrePlacesRestantesCours = checkNombrePlace($idCours); // TEST s'il reste des places

            /*
            RAPPEL succession des IFs
            Si l'ajout de l'adhérent (car déjà existant) échoue, REJET (et demande de connexion pour s'inscrire)
            SINON
            On cherche l'adhérent venant d'être ajouté
            S'il n'y a pas assez de place pour le cours, REJET
            SINON
            Si l'inscription (car adhérent déjà inscrit à ce cours) échoue, REJET
            SINON
            Changement nombre de place disponibles (place <- place - 1)
            */

            if($nombrePlacesRestantesCours<=0)
            {
                $erreur_nbPlacesNull = "Inscription annulée - nombre de places insuffisante";
            } 
            else
            {
                if(!updateInscription_add($tableauInscription, $numAdherentInscrit))
                { 
                    $erreur_inscExistante = "Inscription annulée - cet adhérent est déjà inscrit";
                }
                else
                {
                    updateNombreCours_decrease($tableauInscription);
                }
            }
        }
        else // Si je ne suis pas connecté (déjà adhérent ou pas)
        {
            $nom = htmlspecialchars(isset($_POST["join_nom"]) ? $_POST["join_nom"] : '');
            $prenom = htmlspecialchars(isset($_POST["join_prenom"]) ? $_POST["join_prenom"] : '');
            $tel = htmlspecialchars(isset($_POST["join_tel"]) ? $_POST["join_tel"] : '');
            $adresse = htmlspecialchars(isset($_POST["join_adresse"]) ? $_POST["join_adresse"] : '');
            $mail = htmlspecialchars(isset($_POST["join_mail"]) ? $_POST["join_mail"] : '');
            $mdp = htmlspecialchars(isset($_POST["join_mdp"]) ? $_POST["join_mdp"] : '');
            $mdprepeat = htmlspecialchars(isset($_POST["join_mdprepeat"]) ? $_POST["join_mdprepeat"] : '');
            $idCours = htmlspecialchars(isset($_POST["cours_choix"]) ? $_POST["cours_choix"] : '');
    
            $tableauInscription = [$nom,$prenom,$tel,$adresse,$mail,$mdp,$idCours];
            var_dump($tableauInscription);
    
            $nombrePlacesRestantesCours = checkNombrePlace($idCours); // TEST s'il reste des places
    
            /*
            RAPPEL succession des IFs
            Si l'ajout de l'adhérent (car déjà existant) échoue, REJET (et demande de connexion pour s'inscrire)
            SINON
            On cherche l'adhérent venant d'être ajouté
            S'il n'y a pas assez de place pour le cours, REJET
            SINON
            Si l'inscription (car adhérent déjà inscrit à ce cours) échoue, REJET
            SINON
            Changement nombre de place disponibles (place <- place - 1)
            */
    
            if(!inscriptionAdherent3($tableauInscription))
            {
                $erreur_adhExistant = "Inscription annulée - adhérent déjà existant";
                $action = "voirInscription";
            }
            else
            {
                    
                 $numAdherentInscrit = getLastAdherentUpdated($tableauInscription);
                 var_dump($numAdherentInscrit);
    
                if($nombrePlacesRestantesCours<=0)
                {
                    $erreur_nbPlacesNull = "Inscription annulée - nombre de places insuffisante";
                } 
                else
                {
                    if(!updateInscription_add($tableauInscription, $numAdherentInscrit))
                    { 
                        $erreur_inscExistante = "Inscription annulée - cet adhérent est déjà inscrit";
                    }
                    else
                    {
                        updateNombreCours_decrease($tableauInscription);
                    }
                }
    
                /*Après le succès de l'inscription, retour à la page d'accueil, connecté(e)*/
                $info_adh = getAdherent3($mail, $mdp);
                if($info_adh == false)
                {
                    // echo "ERREUR - pas d'adherent trouvé";
                    $action = 'voirConnexion';
                    $erreur_connexion = "ERREUR - pas d'adherent trouvé";
                } 
                else 
                {
                    // echo "adherent trouve !";
                    $_SESSION["est_connecte"] = "user_connected";
                    $_SESSION["id_user"] = $info_adh[0]["adherent_id"];
                    $_SESSION["user_info"] = $info_adh[0];

                    $action = 'accueil';
                }
    
            }

        }
    }

// Check si SUPPRIMER INSCRIPTION ET si oui on supprime -----------------------------------------------------------------------------
    if(isset($_POST["suppression_inscription"])){
        $idAdherent = htmlspecialchars(isset($_POST["id_adherent"])?$_POST["id_adherent"]:"");
        $idCours = htmlspecialchars(isset($_POST["id_cours"])?$_POST["id_cours"]:"");
        // var_dump($_POST);
        if(!updateInscription_supprimer($idAdherent, $idCours)){
            // echo "ERREUR - suppression annnulée";
            echo "<script type='text/javascript'>alert('ERREUR - suppression annnulée')</script>";
        } else {
            // echo "Suppression en cours - vérifiez";
            if(!updateNombreCours_increase2($idCours)){
                // echo "ERREUR - nombre de place pas mis à jour";
                echo "<script type='text/javascript'>alert('ERREUR - nombre de place pas mis à jour')</script>";
            }else{
                // echo "Rajout d'une place pour le cours";
                echo "<script type='text/javascript'>alert('Suppression effectuée avec succès')</script>";
            }
        }
        $action = 'voirInscriptionsAdh';
        // header("Location: index.php");
    }

// CHECK si connexion ET si oui tentative connexion -----------------------------------------------------------------------------
    if(isset($_POST["connexion_adh"])){
        $adh_mail = htmlspecialchars(isset($_POST["connect_mail"])?$_POST["connect_mail"]:"");
        $adh_mdp = htmlspecialchars(isset($_POST["connect_mdp"])?$_POST["connect_mdp"]:"");

        $info_adh = getAdherent3($adh_mail, $adh_mdp);
        if($info_adh == false)
        {
            // echo "ERREUR - pas d'adherent trouvé";
            $action = 'voirConnexion';
            $erreur_connexion = "ERREUR - pas d'adherent trouvé";
        } 
        else 
        {
            // echo "adherent trouve !";
            $_SESSION["est_connecte"] = "user_connected";
            $_SESSION["id_user"] = $info_adh[0]["adherent_id"];
            $_SESSION["user_info"] = $info_adh[0];

            $action = 'accueil';
        }
    }
    


//// ---------------------------------------------------------------------------------------------------------
//// CORPS SITE ---------------------------------------------------------------------------------------------------------------

// Vue - EN-TETE
    include("vues/v_header.php");

// Vue - update suivant $action
    switch($action){
        case 'accueil':
            include("vues/v_body_accueil.php");
            break;

        case 'voirCours':
            // NOTE : ici partie de connexion à la BDD
            // A mettre AVANT le html du body pour avoir accès aux données !
            $bdd = connectBdd();
            // $tabInstruments = getLesInstruments();
            $tabCours = getLesCours();
            include("vues/v_body_cours.php");
            break;

        case 'voirInscription':
            $bdd = connectBdd();
            $listCours = getLesCours();
            $selected[$coursSelectionne] = 'selected="selected"'; // $coursSelectionne dans l'index
            include("vues/v_body_inscription.php");
            break;
        
        case 'voirConnexion':
            include("vues/v_body_connexion.php");
            break;

        case 'voirListeInscription':

            if( isset($_SESSION["est_connecte"]) and $_SESSION["est_connecte"] == "user_connected" and $_SESSION['id_user']==2)
            {
                $bdd = connectBdd();
                $tabInscription = getListInscription();
                include("vues/v_body_list_inscription.php");
                break;
            }
            else
            {
                $action = 'accueil';
                header("Location: index.php");
                break;
            }

        case 'adhDeconnexion':
            end_session();
            header("Location: index.php");
            break;

        case 'voirProfil':
            if( isset($_SESSION["est_connecte"]) and $_SESSION["est_connecte"] == "user_connected")
            {
                include("vues/v_body_profilAdherent.php");
                break;
            }
            else
            {
                $action = 'accueil';
                header("Location: index.php");
                break;
            }

        case 'voirInscriptionsAdh':
            if( isset($_SESSION["est_connecte"]) and $_SESSION["est_connecte"] == "user_connected")
            {
                $bdd = connectBdd();
                $tabInscription = getListInscriptionAdh($_SESSION['id_user']);
                include("vues/v_body_list_inscription.php");
                break;
            }
            else
            {
                $action = 'accueil';
                header("Location: index.php");
                break;
            }

        default : 
            include("vues/v_body_accueil.php");
    }


// Vue - Pied de Page
    include("vues/v_footer.php");

?>

