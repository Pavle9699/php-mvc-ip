<?php

// KLASA DB PODATAK SLUZI ZA TABELOM
// KOJA CUVA UNOSE U MATICKU KNJIGU

class DBBanja extends Tabela 
{
// ATRIBUTI
private $bazapodataka;
private $UspehKonekcijeNaDBMS;
//


public $IMEBANJA;
public $LOKACIJA;
public $TIP;





// METODE

// konstruktor

public function DajKolekcijuSvihPodataka()
{
$SQL = "select * from `banja` ORDER BY id DESC";
$this->UcitajSvePoUpitu($SQL); // puni atribut bazne klase Kolekcija
return $this->Kolekcija; // uzima iz baznek klase vrednost atributa
}

public function DajKolekcijuPodatakaFiltrirano($filterPolje, $filterVrednost, $nacinFiltriranja, $Sortiranje)
{
if ($nacinFiltriranja=="like")
{
$SQL = "select * from `banja` WHERE $filterPolje like '%".$filterVrednost."%' ORDER BY $Sortiranje";
}
else
{
$SQL = "select * from `banja` WHERE $filterPolje ='".$filterVrednost."' ORDER BY $Sortiranje";
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
	$SQL = "INSERT INTO banja(ime, lokacija, tip) VALUES('$this->IMEBANJA', '$this->LOKACIJA', '$this->TIP')";
	$greska=$this->IzvrsiAktivanSQLUpit($SQL);
	
	return $greska;
}

public function ObrisiPodatak($IdZaBrisanje)
{
	$SQL = "DELETE FROM `banja` WHERE ID=".$IdZaBrisanje;
	$greska=$this->IzvrsiAktivanSQLUpit($SQL);
	
	return $greska;
}

public function IzmeniPodatak($IdZaIzmenu, $NovoIme, $NovaLokacija, $NoviTip)
{
	$SQL = "UPDATE `banja` SET ime='".$NovoIme."', lokacija='".$NovaLokacija."', tip='".$NoviTip."'WHERE ID=".$IdZaIzmenu;
	$greska=$this->IzvrsiAktivanSQLUpit($SQL);
	
	return $greska;
}

// ostale metode 




}
?>