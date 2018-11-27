<?php

require_once ("../php_util/connexion.php");
require_once ("function.php");

$req = "select max(annee)+1 as ANNEE from TDF_ETAPE where ville_a = 'PARIS CHAMPS-ELYSEES'";
$cur = PreparerRequeteOCI($conn, $req);
ExecuterRequeteOCI($cur);
LireDonneesOCI1($cur, $tab);
$anneeCreation = $tab[0]['ANNEE'];


if(!anneeCree($conn, $anneeCreation)) { // Est-ce qu'on a mis le nombre de jour de repos
	echo 'Création du nombre de jour de repos';
	include('creerJourDeRepos.html');
} else if(!nombreEpreuveDefini($conn, $anneeCreation) { // Est-ce qu'on a défini le nombre d'épreuve
	
}
$req = "select max(annee)+1 as ANNEE from TDF_ETAPE where ville_a = 'PARIS CHAMPS-ELYSEES'";
$cur = PreparerRequeteOCI($conn, $req);
ExecuterRequeteOCI($cur);
LireDonneesOCI1($cur, $tab);
$anneeCreation = $tab[0]['ANNEE'];




include_once('creer_tdf.html');

?>
