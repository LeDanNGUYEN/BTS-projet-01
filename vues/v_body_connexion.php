
    <div class="body_content">

        <h2>Connexion - Heureux de vous retrouver</h2>
        <h2>Veuillez-vous connecter</h2>

        <form action="index.php" method="post">

            <label for="join_nom">Votre adresse mail</label><br>
            <input type="mail" name="connect_mail" placeholder="Mail" required><br>
            <label for="join_mdp">Votre mot de passe</label><br>
            <input type="password" name="connect_mdp" placeholder="Mot de passe" required><br><br>

            <input type="submit" value="Connexion" name="connexion_adh">

        </form>

        <?php
        if(isset($erreur_connexion) and $erreur_connexion != "")
        {
            echo "<p class='erreur'>Erreur de connexion - mail ou mot de passe non valide</p>";
        }
        ?>

    </div>


