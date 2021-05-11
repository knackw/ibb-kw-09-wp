<?php
$message = "";
$bilderarray = array();
//////////////////////
//xml datei öffnen
//////////////////////

$xmlFile = 'alleBilder.xml';
if ( file_exists( $xmlFile ) ) {
	$xml = simplexml_load_file( $xmlFile );
	//alle eintraege durchlaufen
	foreach ( $xml->Bild as $bild ) {
		//echo 'Id: ' . $user['id'] . '<br>';  
		//echo 'Bildquelle: ' . $bild->Bildquelle . '<br>';
		//echo 'Headline: ' . $bild->Headline . '<br>';
		//echo 'Fliesstext: ' . $bild->Fliesstext . '<br>';
		//echo 'Autor: ' . $bild->Autor . '<br>';
		$einbild = array();
		$einbild[ 'bildquelle' ] = $bild->Bildquelle;
		$einbild[ 'headline' ] = $bild->Headline;
		$einbild[ 'fliesstext' ] = $bild->Fliesstext;
		$einbild[ 'autor' ] = $bild->Autor;
		//eintrag ins bilderarray
		array_push( $bilderarray, $einbild );
	}
	//anzahl bilder eingelesen
	$anzbilder = count( $bilderarray );
	$message .= "anzahl bilder: " . $anzbilder . "\n";
} else {
	$message .= "Datei $xmlFile kann nicht geöffnet werden.\n";
}


$sendarray = array();
$sendarray[ 'message' ] = $message;
$sendarray[ 'bilderarray' ] = $bilderarray;

echo json_encode( $sendarray );

?>