<?php
//////////////////////////// Informationen \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ 
session_start();
if(!isset($_SESSION['userid']) && isset($_COOKIE['identifier'])){
    $_SESSION['userid'] = $user['id'];
}
if(!isset($_SESSION['userid'])) {
    header('location:login');
}
if(!isset($_GET["key"])){
    header("location:index");
}

$key = htmlspecialchars($_GET["key"]);
$pdo = new PDO("mysql:host=127.0.0.1;dbname=abikarten","web","vKf{DGl1WYon");

$statement = $pdo->prepare("SELECT * FROM guests WHERE `qr` = :qr");
$result = $statement->execute(array('qr' => $key));
$dbguest = $statement->fetch();

if($dbguest == false){
    header('location:index');
}

$guest = $dbguest["name"];
$student = $dbguest["student"];
$date = date("d.m.Y");
$pdfAuthor = "Abi Jahrgang 19/20 OHG";

$option = $_GET["option"];
$logo = '<img src="logo.png">';
$code = '<img id="barcode" 
src="https://api.qrserver.com/v1/create-qr-code/?data=http://ohg-abi.de/qr?key='.$_GET["key"].'&amp;size=100x100" 
width="110" 
height="110" />';
 

$footer = "Der auf diesem Dokument zu findende QR Code berechtigt die auf dem QR Code hinterlegte und in diesem Dokument genannte Person zum Eintritt auf die Abiturfeier des Abiturjahrgangs 2019/20 am Otto-Hahn-Gymnasium Saarbrücken. Diese Eintrittskarte kann, muss aber nicht ausgedruckt mitgebracht werden. Der Digitale QR Code ist zum Einlass ausreichend.";
 
$pdfName = "Karte_".$guest."_abifeier.pdf";
 
 
//////////////////////////// Inhalt des PDFs als HTML-Code \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 
$html = '
<h1>Eintrittskarte für die Abiturfeier des Abiturjahrgangs 19/20 des Otto-Hahn-Gymnasiums Saarbrücken</h1>
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
    <tr>
        <table>
            <tr>
                <td>
                    Anfahrt:<br>
                    Hotel Stadt Püttlingen<br>
                    66346 Püttlingen<br>
                    Am Burgplatz 18
                </td>
                <td style="text-align: right">
                    Ausstellungsdatum: '.$date.'
                </td>
            </tr>
        </table>
    </tr>
    <br><br>
    <tr>
        Ausgestellt an: '.$guest.'<br>
        Zugehöriger Schüler: '.$student.'
    </tr>
    <br><br><br><br><br>
    <tr>
        <td>'.nl2br(trim($logo)).'</td>
        <td>
            <table>
                <tr>
                    <td style="text-align:center">
                        '.nl2br(trim($code)).'
                    </td>
                </tr>
                <br><br>
                <tr>
                    <td style="text-align:center">
                    Zusätzliche Informationen wie eine Anfahrtsbeschreibung erhalten Sie durch scannen dieses Codes. Er berechtigt Sie ebenfalls zum Einlass der Veranstaltung.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table><hr>'.nl2br($footer);

 
 
//////////////////////////// Erzeugung des PDF Dokuments \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

require_once('tcpdf/tcpdf.php');
 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($pdfAuthor);
$pdf->SetTitle('Eintrittskarte '.$$guest);
$pdf->SetSubject('Eintrittskarte '.$$guest);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');
 
//Ausgabe der PDF
 
//Variante 1: PDF direkt an den Benutzer senden:
$pdf->Output($pdfName, $option);
 
//Variante 2: PDF im Verzeichnis abspeichern:
//$pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
//echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';
 
?>