<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <link rel="stylesheet" href="style2.css"> -->
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
            <li><a href="index.php?action=voirConnexion">Connexion</a></li>
            <li><a href="index.php?action=voirListeInscription">Liste des inscriptions</a></li>

            <?php 
                if(isset($_SESSION["est_connecte"])){
                    if($_SESSION["est_connecte"] == "user_connected"){

                        echo "<li>";
                            echo "<a href=''>Votre compte : XXX</a>";
                            echo "<ul id='submenu'>";
                                echo "<li><a href='index.php?action=voirProfil'>Ton profil</a></li>";
                                echo "<li><a href='index.php?action=voirCoursAdh'>Tes inscriptions</a></li>";
                                echo "<li><a href='index.php?action=adhDeconnexion'>Deconnexion</a></li>";
                            echo "</ul>";
                        echo "</li>";

                    } else {
                        // echo "ERREUR - vous êtes connectés MAIS comment avez-vous fait INCONNU ?";
                    }
                } else {
                    // echo "menu utilisateur connecte indisponible - connectez-vous";
                }
            
            ?>

        </ul>
    </nav>






    
