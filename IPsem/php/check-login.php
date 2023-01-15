<?php
session_start();
// include "../db_conn.php";


if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	require '../klase/BaznaKonekcija.php';
	require '../klase/BaznaTabela.php';
	require '../klase/DBUser.php';

$korisnik='NEPOZNAT KORISNIK';
$objKonekcija = new Konekcija('../klase/BaznaParametriKonekcije.xml');
$objKonekcija->connect();

	$username = test_input($_POST['username']);
	$password = test_input($_POST['password']);
	$role = test_input($_POST['role']);
	if($objKonekcija->konekcijaDB){	
		$korisnikObject = new DBUser($objKonekcija, 'PACIJENTI');
		$postojiKorisnik=$korisnikObject->DaLiPostojiKorisnik($username,$password);
		if (empty($username)) {
		header("Location: ../index.php?error=Korisnicko ime prazno");
	}else if (empty($password)) {
		header("Location: ../index.php?error=Šifra je prazna");
	}else {

		header("Location: ../index.php?error=Neispravni kredencijali");
		// Hashing the password
		//$password = md5($password);
        
        // $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        // $result = mysqli_query($conn, $sql);


        // if (mysqli_num_rows($result) === 1) {
        	// the user name must be unique
        	// $row = mysqli_fetch_assoc($result);
        	// if ($row['password'] === $password && $row['role'] == $role) {
				if ($postojiKorisnik=="DA")
		{
			// rad sa sesijama
;
			$_SESSION['name'] = $korisnikObject->DajImePrijavljenogKorisnika($username,$password);
			$_SESSION['id'] = $korisnikObject->DajIDPrijavljenogKorisnika($username,$password);
			$_SESSION['role'] = $role;
			$_SESSION['username'] = ['username'];

			header("Location: ../home.php");
		}


        	// }else {
        	// 	header("Location: ../index.php?error=Incorect User name or password");
        	// }
        // }else {
        // 	header("Location: ../index.php?error=Incorect User name or password");
        // }

	}

	
}else {
	header("Location: ../index.php");
}}

