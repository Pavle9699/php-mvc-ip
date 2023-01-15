<?php 
   session_start();
   include "db_conn.php";
   if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
	
	require "klase/BaznaKonekcija.php";
require "klase/BaznaTabela.php";
$KonekcijaObject = new Konekcija('klase/BaznaParametriKonekcije.xml');
$KonekcijaObject->connect();
if ($KonekcijaObject->konekcijaDB){

	require "klase/DBUser.php";
		$podatakObject = new DBUser($KonekcijaObject, 'users');
	$KolekcijaZapisa = $podatakObject->DajKolekcijuSvihPodataka();
	$UkupanBrojZapisa = $podatakObject->DajUkupanBrojSvihUsera($KolekcijaZapisa);
}?>

<!DOCTYPE html>
<html>
<head>
	<title>HOME</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
      <div class="container d-flex justify-content-center align-items-center"
      style="min-height: 100vh">
      	<?php if ($_SESSION['role'] == 'doktor') {?>
      		<!-- For Admin -->
      		<div class="card" style="width: 18rem;">
			  <img src="img/admin-default.png" 
			       class="card-img-top" 
			       alt="admin image">
			  <div class="card-body text-center">
			    <h5 class="card-title">
			    	<?=$_SESSION['name']?>
			    </h5>
			    <a href="logout.php" class="btn btn-dark">Logout</a>
                <a href="edits.php" class="btn btn-dark"> Unos </a>
                <a href="read.php" class="btn btn-dark">Pregled</a>
			  </div>
			</div>
			<div class="p-3">
                  
				<h1 class="display-4 fs-1">Osoblje</h1>
				<table class="table" 
				       style="width: 32rem;">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Ime</th>
				      <th scope="col">Korisnicko ime</th>
				      <th scope="col">Pozicija</th>
				    </tr>
				  </thead>
				  <tbody>
				  <?php 
					if ($UkupanBrojZapisa>0) {
						for ($RBZapisa = 0; $RBZapisa < $UkupanBrojZapisa; $RBZapisa++) 
						{
												
							// CITANJE VREDNOSTI IZ MEMORIJSKE KOLEKCIJE $RESULT I DODELJIVANJE PROMENLJIVIM
							$id=$podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $RBZapisa, 0);
							$role=$podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $RBZapisa, 1);
							$username=$podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $RBZapisa, 2);
							$password=$podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $RBZapisa, 3);
							$name=$podatakObject->DajVrednostPoRednomBrojuZapisaPoRBPolja ($KolekcijaZapisa, $RBZapisa, 4);
					
			  	 ?>
			    <tr>
				    <tr>
				      <th scope="row"><?=$id?></th>
				      <td><?php echo $name;?></td>
				      <td><?php echo $username;?></td>
				      <td><?php echo $role;?></td>
				    </tr>
				    <?php }?>
				  </tbody>
				</table>
				<?php }?>
			</div>
      	<?php }else { ?>
      		<!-- FORE USERS -->
      		<div class="card" style="width: 18rem;">
			  <img src="img/user-default.png" 
			       class="card-img-top" 
			       alt="admin image">
			  <div class="card-body text-center">
			    <h5 class="card-title">
			    	<?=$_SESSION['name']?>
			    </h5>
			    <a href="logout.php" class="btn btn-dark">Logout</a>
                <a href="read.php" class="btn btn-dark">Pregled</a>
			  </div>
			</div>
      	<?php } ?>
      </div>
</body>
</html>
<?php }else{
	header("Location: index.php");
} ?>