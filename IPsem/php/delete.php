<?php session_start(); ?>


<?php
$id = $_GET['id'];
//including the database connection file
require "../klase/BaznaKonekcija.php";
require "../klase/BaznaTabela.php";
$KonekcijaObject = new Konekcija('../klase/baznaParametriKonekcije.xml');
$KonekcijaObject->connect();
if ($KonekcijaObject->konekcijaDB) // uspesno realizovana konekcija ka DBMS i bazi podataka
{ 
	require "../klase/DBPacijent.php";
	$pacijentObjekat = new DBPacijent($KonekcijaObject, 'pacijent');
	$pacijentObjekat->ObrisiPodatak($id);
	}

	$KonekcijaObject->disconnect();

//getting id of the data from url


//deleting the row from table
//$result=mysqli_query($mysqli, "DELETE FROM knjigarodjenih WHERE id=$id");


//redirecting to the display page (view.php in our case)
header("Location:../read.php");
?>

