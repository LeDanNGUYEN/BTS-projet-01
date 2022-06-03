<?php

// require_once("../modele/connect.php");
// require_once("../modele/fonction.php");
// $bdd = connectBdd();

// if( isset($_POST["generate_pdf"]) ){
//     // $adh_id_pdf = $_POST["adh_id"];
//     $adh_id_pdf = htmlspecialchars($_POST["adh_id"] ? $_POST["adh_id"] : '');
//     // var_dump($adh_id_pdf);
//     // var_dump($_POST);
//     $reservation_info_adh = getListInscriptionAdh($adh_id_pdf);
//     // var_dump($reservation_info_adh);
// }

// // INFOS : 
// // c.horaire, c.nbPlace, i.instrument_nom, p.prof_nom, p.prof_prenom, a.nom, a.prenom

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style3.css">

    <style>
        /*HTML*/
        /*code pour attacher le footer en bas de page*/
        html{
            height: 100%;
        }

        /*BODY global*/
        body{
            margin: 0;
            padding: 0;

            min-height: 100%;

            display: flex;
            flex-direction: column;

            /*font-size: 1em;*/
        }

        /*HEADER HEADER*/

        #header_style{
            display: flex;
            column-gap: 20px; /*Avec le margin auto, plus besoin de valeur...*/
            border: 10px;
            color: rgb(0, 0, 0);
            background: #97cfee;
            padding: 0px 20px 10px;
            margin: 0;
        }

        #header_style h1{
            margin: auto;
            font-weight: bolder;
            font-size: 3.5em;
            text-align: center;
        }

        /*HEADER MENU*/
        /*élément FLEX dans menu ul*/

        .menu ul, .menu li{
            margin: 0;
            padding: 0;
        }

        .menu ul{
            /*background: gray;*/
            background: #30A6E6;
            list-style: none;
            width: 100%;
            display: flex;
        }

        .menu li{
            position: relative;
            width: auto;
        }

        .menu a {
            background: #30A6E6;
            color: #ffffff;
            display: block;
            font: bold 12px/20px sans-serif;
            padding: 10px 25px;
            text-align: center;
            text-decoration: none;
            -webkit-transition: all .25s ease;
            -moz-transition: all .25s ease;
            -ms-transition: all .25s ease;
            -o-transition: all .25s ease;
            transition: all .25s ease;
        }
        .menu li:hover a {
            background: #000000;
        }
        #submenu {
            left: 0;
            opacity: 0;
            position: absolute;
            top: 35px;
            visibility: hidden;
            z-index: 1;

            display: block;
        }
        li:hover ul#submenu {
            opacity: 1;
            top: 40px;	/* adjust this as per top nav padding top & bottom comes */
            visibility: visible;
        }
        #submenu li {
            float: none;
            width: 100%;
        }
        #submenu a:hover {
            background: #DF4B05;
        }
        #submenu a {
            background-color:#000000;
        }

        /*FOOTER*/

        .footer_style{
            border: 10px;
            color: rgb(255, 255, 255);
            background: #30A6E6;
            padding: 0 20px;
            margin: 0;
            margin-top: auto;
        }

        /*BODY CONTENU*/

        .body_content{
            padding: 0px 0px 20px 20px;
            background-color: #fdb126;
            height: auto;
            flex: 1 1 auto; /*Pour remplir la page complètement*/
            color: #000000;
        }

        .body_content ul{
            list-style: none;
        }

        .body_content li{
            position: relative;
            width: auto;

            background: #daac5d;
            color: #000000;
            display: block;
            font: bold 12px/20px sans-serif;
            padding: 10px 25px;
            margin: 10px 20px;
            text-align: center;
            text-decoration: none;

            border: 5px solid #000000;
            row-gap: 5px;
        }

        .test{
            background-color: #DF4B05;
            font: bolder;
            margin: auto;
            padding: 50px 50px;
        }

    </style>

    <title>Document</title>
</head>
<body>
    <?php
    include("v_header.php");
    ?>

    <div class="body_content">
        <h2>COURS & INSTRUMENTS</h2>

        <ul>
            <?php
            foreach($reservation_info_adh as $reservation){
                // echo "INSCRIPTION COURS pour : ".$reservation["nom"]." ".$reservation["prenom"];
                echo "<li>INSCRIPTION COURS pour : ".$reservation["nom"]." ".$reservation["prenom"]
                ."<br>Horaire : ".$reservation["horaire"]
                ."<br>Nombre de places : ".$reservation["nbPlace"]
                //."<br>Professeur (id) : ".$cours["idProfesseur"]
                ."<br>Professeur : ".$reservation["prof_nom"]." ".$reservation["prof_prenom"]
                //."<br>Instrument (id) : ".$cours["idInstrument"]
                ."<br>Instrument : ".$reservation["instrument_nom"]
                ."</li>";
            }
            ?>
        </ul>

    </div>
    
    <!-- <form action="../modele/generatePdf.php" method="post">
        <input type="submit" value="TELECHARGE MOI !!!!!">
    </form> -->

    <?php
    include("v_footer.php");
    ?>
    
</body>
</html>