<?php
		//für anhängen an bestehender xml datei virtuelles document erstellen
		$xmldoc = new DomDocument( '1.0' );
		$xmldoc->preserveWhiteSpace = false;
		$xmldoc->formatOutput = true;

		//kontrollvar
		$message = "";

		//variablen aus form
		$headline = $_POST['headline'];
		$message .= "headline: " . $headline . "\n";
		$fliesstext = $_POST['fliesstext'];
		$message .= "fliesstext: " . $fliesstext . "\n";
		$autor = $_POST['autor'];
		$message .= "autor: " . $autor . "\n";

		$bild = $_FILES['bild'];
		$bildname = $bild['name'];
		$message .= "bildname: " . $bildname . "\n";
		$bilddata = $bild['tmp_name'];
		$message .= "tmpname: " . $bilddata . "\n";
	
		//test auf fehler
		$fehlerstatus = false;
		//jpg testen
		$bildtype = $bild['type'];
		$message .= "bildtyp: " . $bildtype . "\n";
		if($bildtype == "image/jpeg") {
			$message .= "bildtype ok \n";
		}
		else {
			$message .= "bildtype error \n";
			$fehlerstatus = true;
		}
		//bildgroesse testen
		$bildsize = $bild['size'];
		$message .= "bildgroesse: " . $bildsize . "\n";
		if($bildsize > 2 * 1024 * 1024) {
			$message .= "bildgroesse error \n";
			$fehlerstatus = true;
		}
		else {
			$message .= "bildgroesse ok \n";
		}

		//wenn keine fehler dann....
		if($fehlerstatus == false) {
			//neuern dateinamen erzeugen
			$sekunden = time();
			$zufname = md5( $sekunden );
			$zufname = substr( $zufname, 0, 10 ) . ".jpg";
			//temporäre datei verschieben
			if(@move_uploaded_file($bilddata, "../../bilder/" . $zufname) == true) {
				$message .= "UPLOAD OK\n";
			
			
				//icon erzeugen
				$bildpfad = "../../bilder/" . $zufname;
				$info = getimagesize($bildpfad);
				$message .= "breite bild: " . $info[0] . "\n";
				$message .= "höhe bild: " . $info[1] . "\n";
				$message .= "bildtype: " . $info[2] . "\n";
				$message .= "string: " . $info[3] . "\n";
			
				$hoehe = 500;
				$faktor = $hoehe / $info[1];
				$breite =  $info[0] * $faktor;
				$message .= "breite: " . $breite . "\n";
			
				$image_p = imagecreatetruecolor($breite, $hoehe);
				$image = imagecreatefromjpeg($bildpfad);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $breite, $hoehe, $info[0], $info[1]);
			
				$smallFile = "../../bilder/thumbs/" . $zufname;
				if(imagejpeg($image_p, $smallFile, 100) == true) {
					$message .= "icon erzeugen ok\n";
				}
				else {
					$message .= "icon erzeugen error\n";
				}
			
			
			
			
				///////////////////////////////////////////////////////////
				//wenn xml existiert neue daten anhängen, sonst neue bauen
				///////////////////////////////////////////////////////////
			
				$xmlexist = file_exists( 'alleBilder.xml');
				//test datei vorhanden
				if(  $xmlexist == true) {
					$message .= "xml datei vorhanden \n";
					$xml = file_get_contents( 'alleBilder.xml');
    				$xmldoc->loadXML( $xml, LIBXML_NOBLANKS );
    				// find the headercontent tag
    				$root = $xmldoc->getElementsByTagName('alleBilder')->item(0);
				}
				else {
					$message .= "xml datei neuanlage \n";
					$root = $xmldoc->createElement('alleBilder');
					$xmldoc->appendChild($root);
					//$xmlexist = false;
				}
				// create the bild tag mit attribut kategorie
    			$bild = $xmldoc->createElement('Bild');
    			$numAttribute = $xmldoc->createAttribute("kategorie");
    			$numAttribute->value = "Foto";
    			$bild->appendChild($numAttribute);
				//in bestehenden baum einfügen oder neuen baum erzeugen
				if($xmlexist == true) {}
    				// add the product tag before the first element in the <headercontent> tag
    				$root->insertBefore( $bild, $root->firstChild );
				}
				else {
					//neuer baum
					$root->appendChild($bild);
				}

    			// create other elements and add it to the <product> tag.
    			$bildquelleElement = $xmldoc->createElement('Bildquelle');
    			$bild->appendChild($bildquelleElement);
    			$bildquelleText = $xmldoc->createTextNode($zufname);
    			$bildquelleElement->appendChild($bildquelleText);

	 			// create other elements and add it to the <product> tag.
    			$headlineElement = $xmldoc->createElement('Headline');
    			$bild->appendChild($headlineElement);
    			$headlineText = $xmldoc->createTextNode($headline);
    			$headlineElement->appendChild($headlineText);

				// create other elements and add it to the <product> tag.
    			$fliesstextElement = $xmldoc->createElement('Fliesstext');
    			$bild->appendChild($fliesstextElement);
    			$fliesstextText = $xmldoc->createTextNode($fliesstext);
    			$fliesstextElement->appendChild($fliesstextText);
	
				// create other elements and add it to the <product> tag.
    			$autorElement = $xmldoc->createElement('Autor');
    			$bild->appendChild($autorElement);
    			$autorText = $xmldoc->createTextNode($autor);
    			$autorElement->appendChild($autorText);
			
				//datei speichern
				if($xmldoc->save('alleBilder.xml')) {
					$message .= "xml dateischreiben ok \n";
				}
				else {
					$message .= "xml dateischreiben error \n";
				}
    		
			}
		
		else {
			$message .= "UPLOAD ERROR\n";
		}
	

	echo json_encode($message);

?>