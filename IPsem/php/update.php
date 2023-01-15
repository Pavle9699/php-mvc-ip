<?php 

if(isset($_POST['update']))
{	
	$id = $_POST['id'];
        require "../klase/PoslovnaLogika.php";
	$PoslovnaLogikaObject = new PoslovnaLogika();
	


        function validate($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
                
                
               
	}
        $name = validate($_POST['name']);
        $email = validate($_POST['email']);
        $dijagnoza = validate($_POST['dijagnoza']);
        $starost = validate($_POST['starost']);

// 	$sql = "SELECT * FROM pacijenti WHERE id=$id";
//     $result = mysqli_query($conn, $sql);

//     if (mysqli_num_rows($result) > 0) {
//     	$row = mysqli_fetch_assoc($result);
//     }else {
//     	header("Location: read.php");
//     }

if (empty($name)) {
        header("Location: ../update.php?id=$id&error=Ime je obavezno");
}else if (empty($email)) {
        header("Location: ../update.php?id=$id&error=Email je obavezan");
}else{
        //ubacujem dodatni if za starost pa da updejtuje pratnju
        $pratnja = $PoslovnaLogikaObject -> ProveraStarostiZaPratnju($starost);
        $banja_id =$PoslovnaLogikaObject -> ProveraStarostiZaBanju($starost);
        require "../klase/BaznaKonekcija.php";
        require "../klase/BaznaTabela.php";
        $KonekcijaObject = new Konekcija('../klase/BaznaParametriKonekcije.xml');
        $KonekcijaObject->connect();
        
        require "../klase/DBPacijent.php";
		$podatakObject = new DBPacijent($KonekcijaObject, 'pacijenti');
		$greska=$podatakObject->IzmeniPodatak($id, $name, $email, $dijagnoza, $starost, $pratnja,$banja_id);
                header("Location: ../read.php");
}

}