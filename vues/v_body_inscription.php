
    <div class="body_content">
        <h2>INSCRIPTION / JOINS US</h2>

        <form action="index.php" method="post">

            <label for="join_nom">NOM</label><br>
            <input type="text" name="join_nom" placeholder="Votre nom" required><br>
            <label for="join_prenom">PRENOM</label><br>
            <input type="text" name="join_prenom" placeholder="Votre prénom" required><br>
            <label for="join_tel">Téléphone</label><br>
            <input type="tel" name="join_tel" placeholder="téléphone" required><br>
            <label for="join_adresse">Adresse</label><br>
            <input type="text" name="join_adresse" placeholder="adresse" required><br>
            <label for="join_mail">Mail</label><br>
            <input type="mail" name="join_mail" placeholder="mail" required><br>
            <label for="join_mdp">Mot de passe</label><br>
            <input type="password" name="join_mdp" placeholder="mot de passe" required><br>
            <label for="join_mdp">Veuillez entrer votre mot de passe de nouveau</label><br>
            <input type="password" name="join_mdprepeat" placeholder="mot de passe" required><br><br>

            <label for="cours_choix">Veuillez choisir votre cours</label><br>
            <select name="cours_choix" required>
                <option value="" selected="selected">-</option> <!--ICI valeur nulle, par défaut-->
                <?php
                // $listCours = getLesCours();
                // $selected[$coursSelectionne] = 'selected="selected"'; // $coursSelectionne dans l'index

                foreach($listCours as $cours){
                    echo "<option value=' ".$cours["cours_id"]."' ".$selected[$cours['cours_id']].">";
                    echo $cours["horaire"],' / ',
                        $cours["nbPlace"],' places / ',
                        $cours["prof_nom"]." ".$cours["prof_prenom"],' / ',
                        $cours["instrument_nom"],' / ',
                        $cours["cours_id"];
                    echo "</option>";
                }
                ?>

            </select><br><br>

            <input type="submit" value="inscription" name="submit">

        </form>

    </div>

    <!-- <div class="test">
        <p>Oui test pour voir si je peux changer le CSS</p>
    </div> -->

