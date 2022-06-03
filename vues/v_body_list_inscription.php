
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
            // $tabInscription;
            // var_dump($tabInscription);

            foreach($tabInscription as $inscription){
                echo "<tr>";
                    $inscription_infos_triees = array_diff_key($inscription, array('adherent_id' => NULL, 'cours_id' => NULL));
                    foreach($inscription_infos_triees as $detail_inscription){ // Affichage des informations
                        echo "<td>".$detail_inscription."</td>";
                    }
                // Form/Bouton pour telecharger pdf
                    // echo "<td><form action='vues/v_body_resa_pdf.php' method='post' target='_blank'>
                    echo "<td><form action='modele/generatePdf.php' method='post' target='_blank'>";
                    echo "<input type='hidden' name='adh_id' value='".$inscription['adherent_id']."'>";
                                // .$adh_info = getListInscriptionAdh($inscription['adherent_id']).
                    echo "<input type='submit' value='TELECHARGE MOI !!!' name='generate_pdf'>";
                    echo "</form></td>";
                // Form/Bouton pour supprimer
                    // echo "<td>X</td>";
                    echo "<td><form action='index.php' method='post'>";
                    echo "<input type='hidden' name='id_adherent' value='".$inscription['adherent_id']."'>";
                    echo "<input type='hidden' name='id_cours' value='".$inscription['cours_id']."'>";
                    echo "<input type='submit' value='Supprimer' name='suppression_inscription'>";
                    echo "</form></td>";

                // A supprimer : aide affichage adherent_id
                    echo "<td>".$inscription['adherent_id']."</td>";
                    // echo "<td>".$inscription['adherent_id']."</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <!-- <a href="reservation_pdf.php">Export PDF</a>
        <form action="reservation_pdf.php" method="post">
            <input type="hidden" name="user_info" value="">
            <?php
                // $adh_info = getListInscriptionAdh($inscription['adherent_id']);
            ?>
            <input type="submit" value="EXPORTE MOI !!!" name="generate_pdf">
        </form> -->

        <!-- <form action="vues\reservation_pdf.php" method="post" target='_blank'>
            <input type="submit" value="EXPORTE MOI !!!" name="generate_pdf">
        </form> -->

    </div>

    <!-- <td><form action='index.php' method='post'>
            <input type='hidden' name='id_adherent' value='BOB'>
            <input type='hidden' name='id_cours' value='BOB2'>
            <input type='submit' value='Supprimer' name='suppression_inscription'>
    </form></td> -->