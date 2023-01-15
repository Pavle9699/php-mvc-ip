<?php

// KLASA DB PODATAK SLUZI ZA TABELOM
// KOJA CUVA UNOSE U MATICKU KNJIGU

class DBPacijent extends Tabela 
{
// ATRIBUTI
private $bazapodataka;
private $UspehKonekcijeNaDBMS;
//


public $IME;
public $EMAIL;
public $DIJAGNOZA;
// Zameni starost kao godina rodjenja - pa se menja(izracunava)
public $STAROST;//godina rodjenja
public $PRATNJA;
//foreign key
public $IDBANJA;
public $SIFRATERAPIJE;




// METODE

// konstruktor

public function DajKolekcijuSvihPodataka()
{
$SQL = "select * from `pacijenti` ORDER BY id DESC";
$this->UcitajSvePoUpitu($SQL); // puni atribut bazne klase Kolekcija
return $this->Kolekcija; // uzima iz baznek klase vrednost atributa
}

public function DajKolekcijuPodatakaFiltrirano($filterPolje, $filterVrednost, $nacinFiltriranja, $Sortiranje)
{
if ($nacinFiltriranja=="like")
{
$SQL = "select * from `pacijenti` WHERE $filterPolje like '%".$filterVrednost."%' ORDER BY $Sortiranje";
}
else
{
$SQL = "select * from `pacijenti` WHERE $filterPolje ='".$filterVrednost."' ORDER BY $Sortiranje";
}
$this->UcitajSvePoUpitu($SQL);
return $this->Kolekcija; // uzima iz baznek klase vrednost atributa
}


public function DajUkupanBrojSvihPodataka($KolekcijaZapisa)
{
return $this->BrojZapisa;
}

public function DodajNoviPodatak()
{
	$SQL = "INSERT INTO pacijenti(name, email, dijagnoza, starost, pratnja, banja_id, sifra_terapije) VALUES('$this->IME', '$this->EMAIL', '$this->DIJAGNOZA', '$this->STAROST', '$this->PRATNJA', '$this->IDBANJA', '$this->SIFRATERAPIJE')";
	$greska=$this->IzvrsiAktivanSQLUpit($SQL);
	
	return $greska;
}

public function ObrisiPodatak($IdZaBrisanje)
{
	$SQL = "DELETE FROM `pacijenti` WHERE ID=".$IdZaBrisanje;
	$greska=$this->IzvrsiAktivanSQLUpit($SQL);
	
	return $greska;
}

public function IzmeniPodatak($IdZaIzmenu, $NovoIme, $NoviEmail, $NovaDijagnoza,  $NovaStarost, $NovaPratnja, $NoviIdBanje)
{
	$SQL = "UPDATE `pacijenti` SET name='".$NovoIme."', email='".$NoviEmail."', dijagnoza='".$NovaDijagnoza."', starost='".$NovaStarost."', pratnja='".$NovaPratnja."', banja_id ='".$NoviIdBanje."' WHERE ID=".$IdZaIzmenu;
	$greska=$this->IzvrsiAktivanSQLUpit($SQL);
	
	return $greska;
}

// ostale metode 




}
?>