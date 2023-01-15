<?php include 'php/update.php'; 

 
   session_start();
   include "db_conn.php";
   if (isset($_SESSION['name']) && isset($_SESSION['id'])) { 
   }



	$id=$_GET['id'];

	//otvaranje konkekcije
	require "klase/BaznaKonekcija.php";
	require "klase/BaznaTabela.php";
	$KonekcijaObject = new Konekcija('klase/BaznaParametriKonekcije.xml');
	$KonekcijaObject->connect();

	if ($KonekcijaObject->konekcijaDB) // uspesno realizovana konekcija ka DBMS i bazi podataka
		{	
			require "klase/DBPacijent.php";
            require "klase/DBBanja.php";
            require "klase/DBTerapija.php";

            $terapijaObjekat = new DBTerapija($KonekcijaObject, 'terapija');
			$podatakObject = new DBPacijent($KonekcijaObject, 'pacijenti');
           
			$KolekcijaZapisa=$podatakObject->DajKolekcijuPodatakaFiltrirano("id", $id, "=", "id");
			$UkupanBrojZapisa =$podatakObject->DajUkupanBrojSvihPodataka($KolekcijaZapisa);

            $banjaObjekat = new DBBanja($KonekcijaObject,'banja');
            


			if ($UkupanBrojZapisa>0) 
			{
				$row=0;  // prvi i jedini red ima taj idvesti
				$id=$podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $row, 0);
				$name=$podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $row, 1);//mysql_result($result,$row,"REGISTARSKIBROJ");
				$email=$podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $row, 2);
				$dijagnoza=$podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $row, 3);
                $starost=$podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $row, 4);
				$pratnja=$podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $row, 5);
                $banja_id=$podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $row, 6);
                $sifra_terapije = $podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja($KolekcijaZapisa, $row, 7);   

				$banja_podaci = $banjaObjekat->DajKolekcijuPodatakaFiltrirano("id", $banja_id,"=", "id");
                $ime_banje = $banjaObjekat->DajVrednostPoRednomBrojuZapisaPoRBPolja ($banja_podaci, $row, 1);

                $terapija_podaci = $terapijaObjekat->DajKolekcijuPodatakaFiltrirano("sifra_terapije", $sifra_terapije, "=", "sifra_terapije");
		        $naziv_terapije = $terapijaObjekat->DajVrednostPoRednomBrojuZapisaPoRBPolja($terapija_podaci, $row, 1);
                

				
			}         
		} // od if uspeh konekcije

      $KonekcijaObject->disconnect();
	?>

	
	

<!DOCTYPE html>
<html>
<head>
	<title>Nalaz</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	
<div style="height:100vh; text-align:center; display:flex; justify-content:center">
<table class = "print" style="align-self: left; border: 1px solid black; height:70vh; width:700px;">
<tr>
            <td style="width:33%; border: 1px solid black" ><label style="font-weight: 700;">Id</label></td>
            <td style="width:66%; border: 1px solid black"><?php echo $id; ?></td>
        </tr>
        <tr>
            <td style="width:33%; border: 1px solid black"><label style="font-weight: 700;">Ime pacijenta</label></td>
            <td style="width:66%; border: 1px solid black"><?php echo $name; ?></td>
        </tr>
        <tr>
            <td style="width:33%; border: 1px solid black"><label style="font-weight: 700;">Email pacijenta</label></td>
            <td style="width:66%; border: 1px solid black"><?php echo $email; ?></td>
        </tr>
        <tr>
            <td style="width:33%; border: 1px solid black"><label style="font-weight: 700;">Dijagnoza</label></td>
            <td style="width:66%; border: 1px solid black"><?php echo $dijagnoza; ?></td>
        </tr>
        <tr>
            <td style="width:33%; border: 1px solid black"><label style="font-weight: 700;">Terapija</label></td>
            <td style="width:66%; border: 1px solid black"><?php echo $naziv_terapije; ?></td>
        </tr>
        <tr>
            <td style="width:33%; border: 1px solid black"><label style="font-weight: 700;">Starost</label></td>
            <td style="width:66%; border: 1px solid black"><?php echo $starost; ?></td>
        </tr>
        <tr>
            <td style="width:33%; border: 1px solid black"><label style="font-weight: 700;">Pratnja?</label></td>
            <td style="width:66%; border: 1px solid black"><?php echo $pratnja; ?></td>
        </tr>
        <tr>
            <td style="width:33%; border: 1px solid black"><label style="font-weight: 700;">Banja</label></td>
            <td style="width:66%; border: 1px solid black"><?php echo $ime_banje; ?></td>
        </tr>
        
</table>

		  

	   
	    
</div>
<a href="read.php" class="link-primary">View</a>
</body>
</html>