<?php

require "klase/BaznaKonekcija.php";
        require "klase/BaznaTabela.php";
        $KonekcijaObject = new Konekcija('klase/BaznaParametriKonekcije.xml');
        $KonekcijaObject->connect();

require "klase/DBTerapija.php";
$terapijaObject = new DBTerapija($KonekcijaObject, 'terapija');
$KolekcijaZapisa = $terapijaObject->DajKolekcijuSvihPodataka();
$UkupanBrojZapisa =$terapijaObject->DajUkupanBrojSvihPodataka($KolekcijaZapisa);



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
		<form action="php/create.php" 
		      method="post">
            
		   <h4 class="display-4 text-center">Unos novog pacijenta</h4><hr><br>
		   <?php if (isset($_GET['error'])) { ?>
		   <div class="alert alert-danger" role="alert">
			  <?php echo $_GET['error']; ?>
		    </div>
		   <?php } ?>
		   <div class="form-group">
		     <label for="name">Ime</label>
		     <input type="name" 
		           class="form-control" 
		           id="name" 
		           name="name" 
		           value="" 
		           placeholder="Unesi ime">
		   </div>

		   <div class="form-group">
		     <label for="email">Email</label>
		     <input type="email" 
		           class="form-control" 
		           id="email" 
		           name="email" 
		           value="" 
		           placeholder="Unesi email">
		   </div>
           <div class="form-group">
		     <label for="name">Dijagnoza</label>
		     <input type="dijagnoza" 
		           class="form-control" 
		           id="dijagnoza" 
		           name="dijagnoza" 
		           value="" 
		           placeholder="Unesi dijagnozu">
		   </div>
           <div class="form-group">
		     <label for="terapija">Terapija</label>
		     <select class="form-group" name="terapija">
                                     <?php
                                     for ($RBZapisa = 0; $RBZapisa < $UkupanBrojZapisa; $RBZapisa++) {

                                         $nazivTerapije=$terapijaObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $RBZapisa, 1);
										 $sifra_terapije = $terapijaObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $RBZapisa, 0);
                                        echo "<option value=\"$sifra_terapije\">" . $nazivTerapije . " </option";
                                        echo "<br>";
                                     }
                                     ?>
                               </select>
		   </div>
           <div class="form-group">
		     <label for="starost">starost</label>
		     <input type="starost" 
		           class="form-control" 
		           id="starost" 
		           name="starost" 
		           value="" 
		           placeholder="Unesi starost">
		   </div>

		   <button type="submit" 
		          class="btn btn-primary"
		          name="create">Kreiraj</button>
		    <a href="read.php" class="link-primary">Pregled</a>
	    </form>
	</div>
</body>
</html>