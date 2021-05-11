	//indiziertes array	
	var bildarray = []; //new Array();
	//objektdefinition für 1 bild
	var bild = {}; //new Object();
	bild.quelle = "b1.jpg";
	bild.ueberschrift = "zielscheibe";
	bild.autor = "Jochen Berg";
	bild.fliesstext = "lorem zielscheibe hjd ghdsfkg hdksjg ";
	//bildinfos in array ablegen
	bildarray[0] = 	bild;
	//objektdefinition für 1 bild....
	bild = new Object();	
	bild.quelle = "b2.jpg";
	bild.ueberschrift = "Püppchen";
	bild.autor = "Jochen Berg";
	bild.fliesstext = "lorem pueppchen hjd ghdsfkg hdksjg ";
	bildarray[1] = 	bild;
	
	bild = new Object();	
	bild.quelle = "b3.jpg";
	bild.ueberschrift = "Lupe";
	bild.autor = "Fritz Berg";
	bild.fliesstext = "lorem lupe hjd ghdsfkg hdksjg ";
	bildarray[2] = 	bild;		
	
	bild = new Object();	
	bild.quelle = "b4.jpg";
	bild.ueberschrift = "XXXXX";
	bild.autor = "Fritz Berg";
	bild.fliesstext = "lorem XXXXX hjd ghdsfkg hdksjg ";
	bildarray[3] = 	bild;			
	
	//ermittlunfg anzahl bilder aus ind. array	
	var anzahl = bildarray.length;	
	
	//für jedes bild eigenschaften (properties) ausgeben
	for(var a = 0; a < anzahl; a++) {	
		console.log(bildarray[a].quelle);
		console.log(bildarray[a].ueberschrift);
		console.log(bildarray[a].autor);
		console.log(bildarray[a].fliesstext);
		console.log("==================");
	}
