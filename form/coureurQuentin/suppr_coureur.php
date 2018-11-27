<?php
require_once ("../php_util/connexion.php");

//echo "test";

if (isset($_POST['cou_num_suppr']) && $_POST['cou_num_suppr']!=''){

	$num = $_POST['cou_num_suppr'];
 
    $req ="DELETE FROM TDF_COUREUR
			WHERE TDF_COUREUR.N_COUREUR = '". $num ."'";
    $cur = PreparerRequeteOCI($conn, $req);
    $res = ExecuterRequeteOCI($cur);
    ValiderTransacOCI($conn);

    $req1 ="DELETE FROM TDF_APP_NATION
			WHERE N_COUREUR = ". $num ;
    $cur1 = PreparerRequeteOCI($conn, $req1);
    $res1 = ExecuterRequeteOCI($cur1);
    ValiderTransacOCI($conn);
	
	echo "Le coureur numéro $_POST[cou_num_suppr] a bien été supprimé !";
}

include('consulter_coureur.php');


?>
