    <div class="body_content">
        <h2>INSCRIPTION / JOINS US</h2>
        
        <form action="index.php" method="post">

            <?php
            if(!isset($_SESSION["est_connecte"]))
            {
                include("v_body_inscription_formNonConnecte.php");
            }
            ?>

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

        <?php
        if(isset($erreur_adhExistant) and $erreur_adhExistant != "")
        {
            echo "<p class='erreur'>".$erreur_adhExistant."<br>Veuillez-vous connecter pour vous inscrire</p>";
        }
        ?>

    </div>

    <!-- <div class="test">
        <p>Oui test pour voir si je peux changer le CSS</p>
    </div> -->

