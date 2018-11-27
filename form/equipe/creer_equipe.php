<?php

/************************** Ajouter dépendances ***********************************/

require_once ("../php_util/connexion.php");
require_once ("../php_util/verif_form.php");

/************************* Vérification caractères ********************************/

if(!empty($_POST['equ_acr'])) {
	try {
		//echo 'Année de création<br>';
		//echo $_POST['equ_acr'].' -> ';
		$annee_creation = dateEquipeCreation($_POST['equ_acr']);
		//echo $annee_creation;
	} catch(Exception $e) {
		echo 'L\'année de création n\'a pas pu être ajoutée pour la raison suivante : '.$e->getMessage();
	}
}

if(!empty($_POST['equ_adi'])) {
	try {
		//echo 'Année de disparition<br>';
		//echo $_POST['equ_adi'].' -> ';
		$annee_disparition = dateEquipeDisparition($_POST['equ_adi'], $_POST['equ_acr']);
		//echo $annee_disparition;
	} catch(Exception $e) {
		echo 'L\'année de disparition n\'a pas pu être ajoutée pour la raison suivante : '.$e->getMessage();
	}
}

/************************** Ajout à la base ***********************************/
/************************ ou retour formulaire ********************************/

if(!isset($annee_creation)) {
	include ("creer_equipe.html");
} else {

    $req1 = "SELECT max(N_EQUIPE) as MAXI from TDF_EQUIPE";
	$cur1 = PreparerRequeteOCI($conn, $req1);
	$res1 = ExecuterRequeteOCI($cur1);
	LiredonneesOCI1($cur1, $resNum);
	$equ_num = $resNum[0]['MAXI'] +1; //Numéro du coureur que l'on crée automatiquement

	$req2 ="INSERT INTO tdf_equipe ( n_equipe, annee_creation, annee_disparition )
          VALUES ($equ_num,$annee_creation";
	if(isset($annee_disparition)) {
		$req2 = "$req2,$annee_disparition";
	}
	else {
		$req2 = "$req2,NULL";
	}

	$req2 = "$req2)";
	//echo $req2;
	//echo '<br>';
	$cur2 = PreparerRequeteOCI($conn, $req2);
	$res2 = ExecuterRequeteOCI($cur2);

	ValiderTransacOCI($conn);
	include ("creer_equipe_message.html");
}

  /*
  if(!isset($annee_disparition) || empty($annee_creation)) {
	$req1 = "SELECT max(N_EQUIPE) as MAXI from TDF_EQUIPE";
	$cur1 = PreparerRequeteOCI($conn, $req1);
	$res1 = ExecuterRequeteOCI($cur1);
	LiredonneesOCI1($cur1, $resNum);

	$equ_num = $resNum[0]['MAXI'] +1; //Numéro du coureur que l'on crée automatiquement

	$req2 ="INSERT INTO tdf_equipe ( n_equipe, annee_creation, annee_disparition )
          VALUES ($equ_num,$annee_creation,NULL)";
	//echo $req2;
	//echo '<br>';
	$cur2 = PreparerRequeteOCI($conn, $req2);
	$res2 = ExecuterRequeteOCI($cur2);
  } else {

	$req1 = "SELECT max(N_EQUIPE) as MAXI from TDF_EQUIPE";
	$cur1 = PreparerRequeteOCI($conn, $req1);
	$res1 = ExecuterRequeteOCI($cur1);
	LiredonneesOCI1($cur1, $resNum);

	$equ_num = $resNum[0]['MAXI'] +1; //Numéro du coureur que l'on créer créé automatiquement

	$req2 ="INSERT INTO tdf_equipe ( n_equipe, annee_creation, annee_disparition )
          VALUES ($equ_num,$annee_creation,$annee_disparition)";
	//echo $req2;
	//echo '<br>';
	$cur2 = PreparerRequeteOCI($conn, $req2);
	$res2 = ExecuterRequeteOCI($cur2);
  }*/






?>
