<?php
class DBUser extends Tabela{

// ATRIBUTI
public $id;
public $role;
public $username;
public $password;
public $ime;

// metode

// ------- konstruktor - uzima se iz klase roditelja - Tabela

// ------- preostale metode

public function UcitajSveKorisnike()
{
		$SQL = "select * from users";
		$this->UcitajSvePoUpitu($SQL);
}

public function DajKolekcijuSvihPodataka()
{
$SQL = "select * from `users` ORDER BY id DESC";
$this->UcitajSvePoUpitu($SQL); // puni atribut bazne klase Kolekcija
return $this->Kolekcija; // uzima iz baznek klase vrednost atributa
}// kraj metode
public function DajUkupanBrojSvihUsera($KolekcijaZapisa)
{
return $this->BrojZapisa;
}

public function DaLiPostojiKorisnik($loginusername,$loginpassword)
{
	$postoji="";
	$SQLKorisnik = "SELECT * FROM `".$this->OtvorenaKonekcija->KompletanNazivBazePodataka."`.`users` WHERE username='".$loginusername."' AND password='".$loginpassword."'";
    $this->UcitajSvePoUpitu($SQLKorisnik);
	$this->PrebaciKolekcijuUListu($this->Kolekcija);
	if ($this->BrojZapisa>0)
	{
		$postoji="DA";
	}  			
	else 
	{
		$postoji="NE";
	}
	return $postoji;
}

public function DajImePrijavljenogKorisnika($loginusername,$loginpassword)
{
	$korisnik="";
	$SQLKorisnik = "SELECT * FROM `".$this->OtvorenaKonekcija->KompletanNazivBazePodataka."`.`users` WHERE username='".$loginusername."' AND password='".$loginpassword."'";
    $this->UcitajSvePoUpitu($SQLKorisnik);
	$this->PrebaciKolekcijuUListu($this->Kolekcija);
	if ($this->BrojZapisa>0)
	{
		// postoji zapis
		foreach ($this->ListaZapisa as $VrednostCvoraListe)
		{
			$ime=$VrednostCvoraListe[1];
			
		}
	}  			
	else 
	{
		$ime='NEPOZNAT KORISNIK';
	}
	return $ime;
}



public function DajIDPrijavljenogKorisnika($loginusername,$loginpassword)
{
	$id=0;
	$SQLKorisnik = "SELECT * FROM `".$this->OtvorenaKonekcija->KompletanNazivBazePodataka."`.`users` WHERE username='".$loginusername."' AND password='".$loginpassword."'";
    $this->UcitajSvePoUpitu($SQLKorisnik);
	$this->PrebaciKolekcijuUListu($this->Kolekcija);
	if ($this->BrojZapisa>0)
	{
		// postoji zapis
		foreach ($this->ListaZapisa as $VrednostCvoraListe)
		{
			$id=$VrednostCvoraListe[0];
		}
	} 
	// else - ostaje 0

	return $id;
}


public function SnimiNovo()
{
	$AktivanSQLUpit = "";
	$this->IzvrsiAktivanSQLUpit($AktivanSQLUpit);
}

// brisanje 
public function Obrisi()
{
	$AktivanSQLUpit = "DELETE from ";
	$this->IzvrsiAktivanSQLUpit($AktivanSQLUpit);
}

public function ObrisiSve()
{
	$AktivanSQLUpit = "DELETE from ";
	$this->IzvrsiAktivanSQLUpit($AktivanSQLUpit);
}

public function IzmeniVrednostPolja()
{	

	// transformisemo datum u formu pogodnu za insert into 
    //	$DatumskaVrednost=date_create($this->Datum_PoslednjePromene);
    //	$DatumUnosa=date_format($DatumskaVrednost,"Y-m-d");  

	// konacan upit
	$AktivanSQLUpit = "UPDATE  SET " ;
	$this->IzvrsiAktivanSQLUpit($AktivanSQLUpit);
} // kraj metode
} // kraj klase
?>