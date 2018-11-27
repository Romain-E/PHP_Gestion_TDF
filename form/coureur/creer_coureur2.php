<?php
require_once ("../php_util/connexion.php");

$erreur = true;
if ( !empty($_POST))
{
    $erreur = false;
    if (!empty($_POST['cou_nom']) && $_POST['cou_nom'] != ""){
        $cou_nom = $_POST['cou_nom'];
	}
    else
    {
        echo "Nom de coureur est vide <br />";
        $erreur = true;
    }
    if (!empty($_POST['cou_pre']) && $_POST['cou_pre'] != "")
        $cou_prenom = $_POST['cou_pre'] ;
    else
    {
        echo "Prenom de coureur est vide <br />";
        $erreur = true;
    }
    if (!empty($_POST['cou_nai']) && $_POST['cou_nai'] != "")
        $cou_naissance = $_POST['cou_nai'] ;
    else
    {
        echo "Année de naissance est vide <br />";
        $erreur = true;
    }
    if (!empty($_POST['cou_apr']) && $_POST['cou_apr'] != "")
        $cou_premiere = $_POST['cou_apr'] ;
    else
    {
        echo "Année de première participation est vide <br />";
        $erreur = true;
    }
	if (!empty($_POST['cou_nat']) && $_POST['cou_nat'] != "")
        $cou_nationalite = $_POST['cou_nat'] ;
    else
    {
        echo "Nationalité est vide <br />";
        $erreur = true;
    }



    if ($erreur == false)
    {
        $req1 = "select max(N_COUREUR) as MAXI from TDF_COUREUR";
        $cur1 = PreparerRequeteOCI($conn, $req1);
        $res1 = ExecuterRequeteOCI($cur1);
        LiredonneesOCI1($cur1, $resNum);

        $cou_num = $resNum[0]['MAXI'] +1;

        echo $cou_num;

        $req2 ="insert into TDF_COUREUR(N_COUREUR, NOM, PRENOM, ANNEE_NAISSANCE, ANNEE_PREM, COMPTE_ORACLE, DATE_INSERT) values (". $cou_num .", '".$cou_nom."', '".$cou_prenom."', ".$cou_naissance.", ".$cou_premiere.", 'ETU2_58', sysdate)";
        $cur2 = PreparerRequeteOCI($conn, $req2);
        $res2 = ExecuterRequeteOCI($cur2);
        ValiderTransacOCI($conn);

        $req3 = "insert into ETU2_58.TDF_APP_NATION(N_COUREUR, CODE_CIO, ANNEE_DEBUT, COMPTE_ORACLE, DATE_INSERT) values (". $cou_num .", '". $cou_nationalite ."', ".$cou_premiere.", 'ETU2_58', sysdate)";
        $cur3 = PreparerRequeteOCI($conn, $req3);
        $res3 = ExecuterRequeteOCI($cur3);
        ValiderTransacOCI($conn);
    }
}
if ($erreur == true)
{
    include ("../php_util/verif_form.php");
    include ("creer_coureur.html");
}
?>
