<html>

    <div class="body_content">
        
        <h2>VOTRE PROFIL</h2>

        <table>

            <tbody>

                <tr>
                    <th>NOM</th>
                    <?php
                    echo "<td>".$_SESSION['user_info']['nom']."</td>";
                    ?>
                    <td></td>
                </tr>
                <tr>
                    <th>PRENOM</th>
                    <?php
                    echo "<td>".$_SESSION['user_info']['prenom']."</td>";
                    ?>
                </tr>
                <tr>
                    <th>TELEPHONE</th>
                    <?php
                    echo "<td>".$_SESSION['user_info']['tel']."</td>";
                    ?>
                </tr>
                <tr>
                    <th>ADRESSE</th>
                    <?php
                    echo "<td>".$_SESSION['user_info']['adresse']."</td>";
                    ?>
                </tr>
                <tr>
                    <th>MAIL</th>
                    <?php
                    echo "<td>".$_SESSION['user_info']['mail']."</td>";
                    ?>
                </tr>
                <tr>
                    <th>Mot de passe</th>
                    <?php
                    echo "<td>".$_SESSION['user_info']['mdp']."</td>";
                    ?>
                </tr>

            </tbody>

        </table>


    </div>

</html>