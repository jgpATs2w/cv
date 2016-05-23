<?
require_once $_SERVER['DOCUMENT_ROOT']."/mod/dompdf/dompdf_config.inc.php";

$dompdf = new DOMPDF();
$dompdf->load_html(file_get_contents('cv_'.$_GET['lang'].'.pdf.html'));
$dompdf->set_paper('A4');
$dompdf->render();
$dompdf->stream($_GET['lang'] === "en" ? "Javier's Resume" : "CV_Javier_Garcia_Parra" .".pdf");
?>
