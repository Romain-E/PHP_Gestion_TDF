<?php

/************************** Ajouter dépendances ***********************************/

require_once ("../php_util/connexion.php");
require_once ("../php_util/verif_form.php");

/************************* Vérification caractères ********************************/

if(isset($_POST['spo_nom'])) {
	try {
		$nom_sponsor = nomSponsor($_POST['spo_nom']);
	} catch(Exception $e) {
		echo 'Nom du sponsor incorrect : '.$e->getMessage().'<br>';
	}
}

if(isset($_POST['spo_nab'])) {
	try {
		$nom_abr_sponsor = nomAbrSponsor($_POST['spo_nab']);
	} catch(Exception $e) {
		echo 'Nom abrégé du sponsor incorrect : '.$e->getMessage().'<br>';
	}
}

if(isset($_POST['spo_ann'])) {
	try {
		if(!is_numeric($_POST['spo_ann']))
			throw new Exception('Ce n\'est pas une annee');
		if($_POST['spo_ann'] < 1903)
			throw new Exception('Année inférieur à 1903');
		$annee_sponsor = $_POST['spo_ann'];
	} catch(Exception $e) {
		echo 'Annee incorrect : '.$e->getMessage().'<br>';
	}
}


/************************** Ajout à la base ***********************************/
/************************ ou retour formulaire ********************************/


//print_r($_POST);
if(isset($nom_sponsor) && isset($nom_abr_sponsor) && isset($_POST['spo_nat']) && isset($annee_sponsor) && isset($_POST['equ_num'])){
	
	$num_equipe_sponsor = $_POST['equ_num'];
	$nat_sponsor = $_POST['spo_nat'];
	/*$req = "select nom, na_sponsor, code_cio, annee_sponsor from tdf_sponsor where n_equipe = $num_equipe_sponsor order by annee_sponsor desc";
	$cur1 = PreparerRequeteOCI($conn, $req);
	$res1 = ExecuterRequeteOCI($cur1);
	LiredonneesOCI1($cur1, $testReg);
	print_r($testReg);
	if($testReg[0]['NOM'] != $nom_sponsor || $testReg[0]['NA_SPONSOR'] != $nom_abr_sponsor || $testReg[0]['CODE_CIO'] != $_POST['spo_nat']) {
		if($testReg['ANNEE_SPONSOR'] < $annee_sponsor) {*/
			$req1 = "SELECT max(N_SPONSOR) as MAXI
			from TDF_SPONSOR
			where N_EQUIPE = $num_equipe_sponsor";
			$cur1 = PreparerRequeteOCI($conn, $req1);
			$res1 = ExecuterRequeteOCI($cur1);
			LiredonneesOCI1($cur1, $resNum);

			$spo_num = $resNum[0]['MAXI'] +1; //Numéro du coureur que l'on créer créé automatiquement	
			
			$nom_sponsor = preg_replace("/'/","''",$nom_sponsor);
			$nom_abr_sponsor = preg_replace("/'/","''",$nom_abr_sponsor);
			
			
			$req2 ="INSERT INTO TDF_SPONSOR (N_EQUIPE, N_SPONSOR, NOM, NA_SPONSOR, CODE_CIO, ANNEE_SPONSOR, COMPTE_ORACLE, DATE_INSERT) VALUES
			(
			$num_equipe_sponsor, 
			$spo_num, 
			'$nom_sponsor', 
			'$nom_abr_sponsor',
			'$nat_sponsor', 
			$annee_sponsor, 
			user, 
			sysdate)";
			//echo $req2;
			$cur2 = PreparerRequeteOCI($conn, $req2);
			$res2 = ExecuterRequeteOCI($cur2);
			ValiderTransacOCI($conn);
			require_once("creer_sponsor_message.html");
		//}
		/*else
			echo 'Annee rentrée inférieur à l\'ancienne de l\'équipe';
	/*}*/
	
	
}
else
	require_once ("creer_sponsor_equipe.html");
?>
