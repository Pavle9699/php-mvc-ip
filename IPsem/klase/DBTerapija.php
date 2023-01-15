<?php

// KLASA DB PODATAK SLUZI ZA TABELOM
// KOJA CUVA UNOSE U MATICKU KNJIGU

class DBTerapija extends Tabela 
{
// ATRIBUTI
private $bazapodataka;
private $UspehKonekcijeNaDBMS;
//


public $STRUCNINAZIV;
public $OPIS;





// METODE

// konstruktor

public function DajKolekcijuSvihPodataka()
{
$SQL = "select * from `terapija` ORDER BY sifra_terapije DESC";
$this->UcitajSvePoUpitu($SQL); // puni atribut bazne klase Kolekcija
return $this->Kolekcija; // uzima iz baznek klase vrednost atributa
}

public function DajKolekcijuPodatakaFiltrirano($filterPolje, $filterVrednost, $nacinFiltriranja, $Sortiranje)
{
if ($nacinFiltriranja=="like")
{
$SQL = "select * from `terapija` WHERE $filterPolje like '%".$filterVrednost."%' ORDER BY $Sortiranje";
}
else
{
$SQL = "select * from `terapija` WHERE $filterPolje ='".$filterVrednost."' ORDER BY $Sortiranje";
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
	$SQL = "INSERT INTO terapija(strucni_naziv, opis) VALUES('$this->STRUCNINAZIV', '$this->OPIS')";
	$greska=$this->IzvrsiAktivanSQLUpit($SQL);
	
	return $greska;
}

public function ObrisiPodatak($IdZaBrisanje)
{
	$SQL = "DELETE FROM `terapija` WHERE sifra_terapije=".$IdZaBrisanje;
	$greska=$this->IzvrsiAktivanSQLUpit($SQL);
	
	return $greska;
}

public function IzmeniPodatak($IdZaIzmenu, $NovIstrucniNaziv, $NoviOpis)
{
	$SQL = "UPDATE `terapija` SET strucni_naziv='".$NovIstrucniNaziv."', opis='".$NoviOpis."'WHERE sifra_terapije=".$IdZaIzmenu;
	$greska=$this->IzvrsiAktivanSQLUpit($SQL);
	
	return $greska;
}

// ostale metode 




}
?>