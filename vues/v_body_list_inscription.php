
<div class="body_content">
        <h2>LISTE DES COURS CONFIRMES</h2>

        <table class="table_style">
            <tr>
                <th>Horaires</th>
                <th>Nbe Places</th>
                <th>Instruments</th>
                <th>PROF-nom</th>
                <th>PROF-prenom</th>
                <th>ELEVE-nom</th>
                <th>ELEVE-prenom</th>
                <th>PDF-Download</th>
                <th>SUPPRIMER Inscription</th>
                <th>A SUPPRIMER : Numéro adhérent</th>
            </tr>

            <?php

            foreach($tabInscription as $inscription){
                echo "<tr>";
                    $inscription_infos_triees = array_diff_key($inscription, array('adherent_id' => NULL, 'cours_id' => NULL));
                    foreach($inscription_infos_triees as $detail_inscription){ // Affichage des informations
                        echo "<td>".$detail_inscription."</td>";
                    }
                // Form/Bouton pour telecharger pdf
                    echo "<td><form action='modele/generatePdf.php' method='post' target='_blank'>";
                    echo "<input type='hidden' name='adh_id' value='".$inscription['adherent_id']."'>";
                    echo "<input type='submit' value='TELECHARGE MOI !!!' name='generate_pdf'>";
                    echo "</form></td>";
                // Form/Bouton pour supprimer
                    echo "<td><form action='index.php' method='post'>";
                    echo "<input type='hidden' name='id_adherent' value='".$inscription['adherent_id']."'>";
                    echo "<input type='hidden' name='id_cours' value='".$inscription['cours_id']."'>";
                    echo "<input type='submit' value='Supprimer' name='suppression_inscription'>";
                    echo "</form></td>";

                // A supprimer : aide affichage adherent_id
                    echo "<td>".$inscription['adherent_id']."</td>";
                echo "</tr>";
            }
            ?>
        </table>

    </div>
