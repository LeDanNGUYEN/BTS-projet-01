

    <div class="body_content">
        <h2>COURS & INSTRUMENTS</h2>

        <!-- Partie PHP qui utilise les données de la BDD -->
        <!-- Car dans le index.php on a fait la connexion AVANT d'inclure cette partie ici -->
        <!--
        <ul>
            <?php
            /*foreach($tabInstruments as $instrument){
                echo "<li>".$instrument["instrument_nom"]."</li>";
            }*/
            ?>
        </ul>
        -->

        <ul>
            <?php
            foreach($tabCours as $cours){
                echo "<li>Horaire : ".$cours["horaire"]
                ."<br>Nombre de places : ".$cours["nbPlace"]
                //."<br>Professeur (id) : ".$cours["idProfesseur"]
                ."<br>Professeur : ".$cours["prof_nom"]." ".$cours["prof_prenom"]
                //."<br>Instrument (id) : ".$cours["idInstrument"]
                ."<br>Instrument : ".$cours["instrument_nom"]
                ."<br><a href='index.php?action=voirInscription&coursSelectionne=".$cours["cours_id"]."'>Inscription</a>"
                ."</li>";
            }
            ?>
        </ul>


    </div>

