<?php

use Dompdf\Dompdf;
use Dompdf\Options;

require_once("../modele/connect.php");
require_once("../modele/fonction.php");
$bdd = connectBdd();

if( isset($_POST["generate_pdf"]) ){
    $adh_id_pdf = htmlspecialchars($_POST["adh_id"] ? $_POST["adh_id"] : '');
    $reservation_info_adh = getListInscriptionAdh($adh_id_pdf);
}

ob_start();

    require_once '../vues/v_body_resa_pdf.php';
    // die;
    $html = ob_get_contents();

ob_end_clean();
// die($html);

require_once '../dompdf/autoload.inc.php';

$options = new Options();
$options->set('defaultFont', 'Courier');

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('A4','portrait');

$dompdf->render();

$fichier = 'ma_RESA.pdf';
$dompdf->stream($fichier);














