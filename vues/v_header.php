<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
    <title>Document</title>
</head>
<body>
    <div id="header_style">
        <img src="images/logo2.png" alt="logo provisoire" title="conservatoire" width="200px">
        <h1>Bienvenue au conservatoire du 19e arrondissement de Paris</h1>
    </div>

    <nav class="menu">
        <ul>
            <li><a href="index.php?action=accueil">Accueil</a></li>
            <li>
                <a href="index.php?action=voirCours">Cours et instruments</a>
                <ul id="submenu">
                    <li><a href="index.php?action=voirCours">Violon</a></li>
                    <li><a href="index.php?action=voirCours">Piano</a></li>
                    <li><a href="index.php?action=voirCours">Guitare</a></li>
                    <li><a href="index.php?action=voirCours">Hautbois</a></li>
                </ul>
            </li>
            <li><a href="index.php?action=voirInscription">Inscription</a></li>

            <?php 
                if(!isset($_SESSION["est_connecte"])){
                    echo("<li><a href='index.php?action=voirConnexion'>Connexion</a></li>");
                    // echo "menu utilisateur connecte indisponible - connectez-vous";

                } else {

                    if($_SESSION["est_connecte"] == "user_connected"){

                        $adhConnecte_nom = $_SESSION['user_info']['nom'];
                        $adhConnecte_prenom = $_SESSION['user_info']['prenom'];

                        include("v_header_connecte.php");

                        if($_SESSION['id_user'] == 2)
                        {
                            echo "<li><a href='index.php?action=voirListeInscription'>Liste des inscriptions</a></li>";
                        }

                    } else {
                        // echo "ERREUR - vous êtes connectés MAIS comment avez-vous fait INCONNU ?";
                    }

                }
            ?>

        </ul>
    </nav>






    
