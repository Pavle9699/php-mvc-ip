<?php

	$id = $_GET['id'];

require "klase/BaznaKonekcija.php";
        require "klase/BaznaTabela.php";
        $KonekcijaObject = new Konekcija('klase/BaznaParametriKonekcije.xml');
        $KonekcijaObject->connect();

require "klase/DBTerapija.php";
require "klase/DBPacijent.php";
require "klase/DBBanja.php";
$podatakObject = new DBPacijent($KonekcijaObject, 'pacijenti');
$terapijaObjekat = new DBTerapija($KonekcijaObject, 'terapija');
$banjaObjekat = new DBBanja($KonekcijaObject, 'banja');
$KolekcijaZapisa = $terapijaObjekat->DajKolekcijuSvihPodataka();
$UkupanBrojZapisa =$terapijaObjekat->DajUkupanBrojSvihPodataka($KolekcijaZapisa);

$KolekcijaZapisa = $podatakObject->DajKolekcijuSvihPodataka();
$UkupanBrojZapisa = $podatakObject->DajUkupanBrojSvihPodataka($KolekcijaZapisa);

if ($UkupanBrojZapisa > 0) {
	
		$row = 0;
		// CITANJE VREDNOSTI IZ MEMORIJSKE KOLEKCIJE $RESULT I DODELJIVANJE PROMENLJIVIM
		$id = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $row, 0);
		$name = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $row, 1);
		$email = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $row, 2);
		$dijagnoza = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $row, 3);
		
		$starost = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $row, 4);
		$pratnja = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $row, 5);
		$banja_id = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $row, 6);
		$sifra_terapije = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $row, 7);
		
		

		$banja_podaci = $banjaObjekat->DajKolekcijuPodatakaFiltrirano("id", $banja_id, "=", "id");
		$ime_banje = $banjaObjekat->DajVrednostPoRednomBrojuZapisaPoRBPolja($banja_podaci, $row, 1);


		$terapija_podaci = $terapijaObjekat->DajKolekcijuPodatakaFiltrirano("sifra_terapije", $sifra_terapije, "=", "sifra_terapije");
		$naziv_terapije = $terapijaObjekat->DajVrednostPoRednomBrojuZapisaPoRBPolja($terapija_podaci, $row, 1);

	
}



?>





<!DOCTYPE html>
<html>
<head>
	<title>Create</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
		<form action="php/update.php" 
		      method="post">
            
		   <h4 class="display-4 text-center">Izmena Pacijenta</h4><hr><br>
		   <?php if (isset($_GET['error'])) { ?>
		   <div class="alert alert-danger" role="alert">
			  <?php echo $_GET['error']; ?>
		    </div>
		   <?php } ?>
		   <input hidden name = "id" id = "id" value="<?php echo $id?>">
		   <div class="form-group">
		     <label for="name">Ime</label>
		     <input type="name" 
		           class="form-control" 
		           id="name" 
		           name="name" 
		           value="<?php echo $name?>" 
		           placeholder="Unesi ime">
		   </div>

		   <div class="form-group">
		     <label for="email">Email</label>
		     <input type="email" 
		           class="form-control" 
		           id="email" 
		           name="email" 
		           value="<?php echo $email?>" 
		           placeholder="Unesi email">
		   </div>
           <div class="form-group">
		     <label for="name">Dijagnoza</label>
		     <input type="dijagnoza" 
		           class="form-control" 
		           id="dijagnoza" 
		           name="dijagnoza" 
		           value="<?php echo $dijagnoza?>" 
		           placeholder="Unesi dijagnozu">
		   </div>

		   <div class="form-group">
		     <label for="starost">terapija</label>
		     <input type="terapija" 
		           class="form-control" 
		           id="terapija" 
		           name="terapija"
				   disabled 
		           value="<?php echo $naziv_terapije?>" 
		           placeholder="Unesi starost">
		   </div>
		   <div class="form-group">
		     <label for="starost">starost</label>
		     <input type="starost" 
		           class="form-control" 
		           id="starost" 
		           name="starost" 
		           value="<?php echo $starost?>" 
		           placeholder="Unesi starost">
		   </div>

		   <button type="submit" 
		          class="btn btn-primary"
		          name="update">Kreiraj</button>
		    <a href="read.php" class="link-primary">Pregled</a>
	    </form>
	</div>
</body>
</html>