<?php
class PoslovnaLogika  
{
// ATRIBUTI
public $GORNJA;
public $DONJA;
//

private $PutanjaNazivFajlaXMLParametriKonekcije;



// PODRAZUMEVANI KONSTRUKTOR
// public function __construct(){

// }
public function __construct($NovaPutanjaNazivFajlaXMLParametriKonekcije)
{
	$this->PutanjaNazivFajlaXMLParametriKonekcije=$NovaPutanjaNazivFajlaXMLParametriKonekcije; 
	//
	
	$this->UcitajPodatkeIzXmla($NovaPutanjaNazivFajlaXMLParametriKonekcije);
}

// FUNKCIJE

public function UcitajPodatkeIzXmla($PutanjaNazivFajlaXMLParametriKonekcije){
    $xml=simplexml_load_file($PutanjaNazivFajlaXMLParametriKonekcije) or die("Greska: Ne postoji fajl BaznaParametriKonekcije.xml");
// ocitavanje elemenata XML fajla u promenljive
$this->GORNJA=$xml->gornja_granica;
$this->DONJA=$xml->donja_granica;

}


public function ProveriIspravnostImenaIPrezimena($name){
    if(!preg_match("/^[\p{L} ,.'-]+$/u", $name)) {
        return true;
    } else {
        return false;
    }
}

public function ProveraPraznihPolja($name,$email,$dijagnoza,$terapija,$starost) {
    if (empty($name) || empty($email) || empty($dijagnoza) || empty($terapija) || empty($starost) ){
        return true;
    }else{
        return false;
    }


}

//promeni fiksne vrednosti u XML fajlu izveden

public function ProveraStarostiZaPratnju($god_rodj){
    //trenutna godina peomenljiva - godina rodjenja
    $trunutna_godina = date("Y");
    $starost= $trunutna_godina - $god_rodj;
    if ($starost<=$this->DONJA){
        return 1;
    }else{
        return 0;
    }
}
public function ProveraStarostiZaBanju($god_rodj){
    $trunutna_godina = date("Y");
    $starost= $trunutna_godina - $god_rodj;
    if($starost>=$this->GORNJA){
        return 1;
    }else{
        return 2;
    }
}

}