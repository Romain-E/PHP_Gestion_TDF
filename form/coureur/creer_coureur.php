<?php

/************************** Ajouter dépendances ***********************************/

require_once ("../php_util/connexion.php");
require_once ("../php_util/verif_form.php");

//print_r($_POST);

/************************* Vérification caractères ********************************/

if(isset($_POST['cou_pre'])) {
	try {
		//echo 'PRENOM<br>';
		//echo $_POST['cou_pre'].' -> ';
		$prenom = prenom($_POST['cou_pre']);
		//echo $prenom;
	} catch(Exception $e ) {
		echo 'Prenom du coureur incorrect : '.$e->getMessage();
	}
	//echo '<br><br><br>';
}

if(!empty($_POST['cou_nom'])) {
	try {
		//echo 'NOM<br>';
		//echo $_POST['cou_nom'].' -> ';
		$nom = nom($_POST['cou_nom']);
		//echo $nom;
	} catch(Exception $e) {
		echo 'Nom du coureur incorrect : '.$e->getMessage();
	}
	//echo '<br><br><br>';
}

if(!empty($_POST['cou_nai'])) {
	try {
		//echo 'Naissance<br>';
		//echo $_POST['cou_nai'].' -> ';
		$nai = dateNaissance($_POST['cou_nai']);
		//echo $nai;
	} catch(Exception $e) {
		echo 'La date de naissance n\a pas pu être ajoutée pour la raison suivante : '.$e->getMessage();
	}
	//echo '<br><br><br>';
}

if(!empty($_POST['cou_apr'])) {
	try {
		//echo 'Première participation<br>';
		//echo $_POST['cou_apr'].' -> ';
		$apr = datePremierePart($_POST['cou_apr'], $_POST['cou_nai']);
		//echo $apr;
	} catch(Exception $e) {
		echo $e->getMessage();
	}
	//echo '<br><br><br>';
}

/************************** Ajout à la base ***********************************/
/************************ ou retour formulaire ********************************/


if(!isset($nom) || !isset($prenom) || dejaDansLaBase($nom, $prenom, $conn)) {
	include ("creer_coureur.html");
} else {
	include ("creer_coureur_message.html");
	$req1 = "select max(N_COUREUR) as MAXI from TDF_APP_NATION";
	$cur1 = PreparerRequeteOCI($conn, $req1);
	$res1 = ExecuterRequeteOCI($cur1);
	LiredonneesOCI1($cur1, $resNum);

	$cou_num = ($resNum[0]['MAXI'] +1); //Numéro du coureur que l'on créer créé automatiquement

	$req2 ="insert into TDF_COUREUR(N_COUREUR, NOM, PRENOM";
	if(isset($nai)) {
		$req2 = $req2.', ANNEE_NAISSANCE';
	}
	if(isset($apr)) {
		$req2 = $req2.', ANNEE_PREM';
	}
	$req2 = "$req2, COMPTE_ORACLE, DATE_INSERT) values ('$cou_num', '$nom', '$prenom'";
	if(isset($nai)) {
		$req2 = "$req2, '$nai'";
	}
	if(isset($apr)) {
		$req2 = "$req2, '$apr'";
	}
	$req2 = "$req2, user, sysdate)";

	//echo $req2;
	//echo '<br>';

	$cur2 = PreparerRequeteOCI($conn, $req2);
	$res2 = ExecuterRequeteOCI($cur2);

	if(isset($_POST['cou_nat'])) {
		$req3 = "insert into TDF_APP_NATION(N_COUREUR, CODE_CIO";
		if(isset($apr)) {
			$req3 = "$req3, ANNEE_DEBUT";
		}
		$req3 = "$req3, COMPTE_ORACLE, DATE_INSERT) values ($cou_num, '$_POST[cou_nat]' ,";
		if(isset($apr)) {
			$req3 = "$req3 '$apr',";
		}
		$req3 = "$req3 user, sysdate)";
		//echo $req3;
		$cur3 = PreparerRequeteOCI($conn, $req3);
		$res3 = ExecuterRequeteOCI($cur3);

	}

	ValiderTransacOCI($conn);

}


function dejaDansLaBase($nom, $prenom, $conn) {	
	$req1 = "select count(*) as NB from tdf_coureur where NOM = '$nom' and PRENOM = '$prenom'";
	//echo $req1;
	$cur1 = PreparerRequeteOCI($conn, $req1);
	$res1 = ExecuterRequeteOCI($cur1);
	LiredonneesOCI1($cur1, $resNum);
	//echo $resNum[0]['NB'];
	if($resNum[0]['NB'] == '0') {
		return false;
	}
	return true;
}
?>
