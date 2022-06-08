<html>

    <li>
        <?php
        echo "<a href='index.php?action=accueil'>Votre compte : ".$adhConnecte_nom." ".$adhConnecte_prenom."</a>";
        ?>
        <ul id='submenu'>
            <li><a href='index.php?action=voirProfil'>Votre profil</a></li>
            <li><a href='index.php?action=voirInscriptionsAdh'>Vos inscriptions</a></li>
            <li><a href='index.php?action=adhDeconnexion'>Deconnexion</a></li>
        </ul>
    </li>

</html>

