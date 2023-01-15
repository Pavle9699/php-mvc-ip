<?php 

if(isset($_POST['create']))
{	
        function validate($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
                
                
               
	}
        $name = validate($_POST['name']);
        $email = validate($_POST['email']);
        $dijagnoza = validate($_POST['dijagnoza']);
        $terapija = validate($_POST['terapija']);
        $starost = validate($_POST['starost']);

        require "../klase/PoslovnaLogika.php";
	$PoslovnaLogikaObject = new PoslovnaLogika("../klase/starost.xml");

// 	$sql = "SELECT * FROM pacijenti WHERE id=$id";
//     $result = mysqli_query($conn, $sql);

//     if (mysqli_num_rows($result) > 0) {
//     	$row = mysqli_fetch_assoc($result);
//     }else {
//     	header("Location: read.php");
//     }

// KReiraj dropdown iz baze da cita, kao sifarnica tabela za dijagnozu ili terapiju.

if (empty($name)) {
        header("Location: ../create.php?id=$id&error=Ime je obavezno");
}else if (empty($email)) {
        header("Location: ../create.php?id=$id&error=Email je obevezan");
}else if (empty($dijagnoza)) {
        header("Location: ../create.php?id=$id&error=Dijagnoza je obavezna");
}else if (empty($terapija)) {
        header("Location: ../create.php?id=$id&error=Terapija je obavezna");
}else if (empty($starost)) {
        header("Location: ../create.php?id=$id&error=Starost je obavezna");
}
elseif ($PoslovnaLogikaObject->ProveriIspravnostImenaIPrezimena($name) == true) {
        header("Location: ../create.php?id=$id&error=Neispravno ime");
        }
        else{
        //ubacujem dodatni if za starost pa da updejtuje pratnju
        $pratnja = $PoslovnaLogikaObject -> ProveraStarostiZaPratnju($starost);
        $banja_id = $PoslovnaLogikaObject-> ProveraStarostiZaBanju($starost);

        require "../klase/BaznaKonekcija.php";
        require "../klase/BaznaTabela.php";
        $KonekcijaObject = new Konekcija('../klase/BaznaParametriKonekcije.xml');
        $KonekcijaObject->connect();
        require "../klase/DBPacijent.php";
		$pacijentObjekat = new DBPacijent($KonekcijaObject, 'pacijent');
		$pacijentObjekat->IME=$name;
		$pacijentObjekat->EMAIL=$email;

		$pacijentObjekat->DIJAGNOZA=$dijagnoza;
		$pacijentObjekat->TERAPIJA=$terapija;

		$pacijentObjekat->STAROST=$starost;
		$pacijentObjekat->PRATNJA=$pratnja;
                $pacijentObjekat->IDBANJA=$banja_id;
                $pacijentObjekat->SIFRATERAPIJE =$terapija;
		
		$greska=$pacijentObjekat->DodajNoviPodatak();
                header('Location: ../read.php');
        
}

}