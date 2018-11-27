<?php

function anneeCree($conn, $anneeCreation){
	$req = "select max(annee) as ANNEE from TDF_ANNEE";
	$cur = PreparerRequeteOCI($conn, $req);
	ExecuterRequeteOCI($cur);
	LireDonneesOCI1($cur, $tab);
	return $tab[0]['ANNEE'] == $anneeCreation;
}


?>