<?php


require "klase/BaznaKonekcija.php";
require "klase/BaznaTabela.php";
$KonekcijaObject = new Konekcija('klase/BaznaParametriKonekcije.xml');
$KonekcijaObject->connect();
if ($KonekcijaObject->konekcijaDB) {

	require "klase/DBPacijent.php";
	require "klase/DBBanja.php";
	require "klase/DBTerapija.php";
	$podatakObject = new DBPacijent($KonekcijaObject, 'pacijenti');

	$terapijaObjekat = new DBTerapija($KonekcijaObject, 'terapija');
	$banjaObjekat = new DBBanja($KonekcijaObject, 'banja');

	if (isset($_GET["filtriraj"])) {
		$filterVrednost = $_GET["filter"];
		$filterPolje = "email";
		$nacinFiltriranja = "like";
		$Sortiranje = "id DESC";
		$KolekcijaZapisa = $podatakObject->DajKolekcijuPodatakaFiltrirano($filterPolje, $filterVrednost, $nacinFiltriranja, $Sortiranje);
		$UkupanBrojZapisa = $podatakObject->DajUkupanBrojSvihPodataka($KolekcijaZapisa);
	} else {
		$KolekcijaZapisa = $podatakObject->DajKolekcijuSvihPodataka();
		$UkupanBrojZapisa = $podatakObject->DajUkupanBrojSvihPodataka($KolekcijaZapisa);
	}
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
		<div class="box">
			<h4 class="display-4 text-center">Pregled Pacijenata</h4><br>
			<?php if (isset($_GET['success'])) { ?>
				<div class="alert alert-success" role="alert">
					<?php echo $_GET['success']; ?>
				</div>
			<?php } ?>
			<div class="formContainer">

				<form class="filterForma" action="" method="GET">
					<input type="name" id="filter" name="filter" value="" placeholder="Unesi email">
					<input type="submit" name="svi" value="svi" />
					<input type="submit" name="filtriraj" value="filtriraj" />
				</form>
			</div>

			<table class="table table-striped">
				<thead>
					<tr>
						<td>

						</td>
					</tr>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Ime</th>
						<th scope="col">Email</th>
						<th scope="col">Dijagnoza</th>
						<th scope="col">Terapija</th>
						<th scope="col">Starost</th>
						<th scope="col">Pratnja</th>
						<th scope="col">Banja</th>
						<th scope="col">Opcije</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ($UkupanBrojZapisa > 0) {
						for ($RBZapisa = 0; $RBZapisa < $UkupanBrojZapisa; $RBZapisa++) {
							$row = 0;
							// CITANJE VREDNOSTI IZ MEMORIJSKE KOLEKCIJE $RESULT I DODELJIVANJE PROMENLJIVIM
							$id = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $RBZapisa, 0);
							$name = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $RBZapisa, 1);
							$email = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $RBZapisa, 2);
							$dijagnoza = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $RBZapisa, 3);
							
							$starost = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $RBZapisa, 4);
							$pratnja = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $RBZapisa, 5);
							$banja_id = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $RBZapisa, 6);
							$sifra_terapije = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $RBZapisa, 7);
							
							

							$banja_podaci = $banjaObjekat->DajKolekcijuPodatakaFiltrirano("id", $banja_id, "=", "id");
							$ime_banje = $banjaObjekat->DajVrednostPoRednomBrojuZapisaPoRBPolja($banja_podaci, $RBZapisa, 1);


							$terapija_podaci = $terapijaObjekat->DajKolekcijuPodatakaFiltrirano("sifra_terapije", $sifra_terapije, "=", "sifra_terapije");
							$naziv_terapije = $terapijaObjekat->DajVrednostPoRednomBrojuZapisaPoRBPolja($terapija_podaci, $RBZapisa, 1);





					?>
							<tr>
								<th scope="row"><?= $id ?></th>
								<td><?php echo $name; ?></td>
								<td><?php echo $email; ?></td>
								<td><?php echo $dijagnoza; ?></td>
								<td><?php echo $naziv_terapije; ?></td>
								<td><?php echo $starost; ?></td>
								<td><?php if ($pratnja == 1) {
										echo "Da";
									} else {
										echo "Ne";
									} ?></td>
								<td><?php echo $ime_banje; ?></td>
								<td><a href="update.php?id=<?php echo $id; ?>" class="btn btn-success">Promeni</a>

									<a href="php/delete.php?id=<?php echo $id; ?>" class="btn btn-danger">Obrisi</a>

									<a href="printform.php?id=<?php echo $id; ?>" class="btn btn-info">Stampaj</a>
								</td>
							</tr>
					<?php }
					} ?>
				</tbody>
			</table>
			<?php //} 
			?>
			<div class="link-right">
				<!-- <a href="edits.php" class="link-primary">Create</a> -->
				<a href="home.php" class="link-primary pl-1">Nazad</a>
			</div>
		</div>
	</div>
</body>

</html>