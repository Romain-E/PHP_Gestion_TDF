<?php
require_once ("../../php_util/connexion.php");

if (isset($_POST['suppr']) && $_POST['suppr']!=''){
	echo "Bienvenue dans suppr";
	
	$val = 'cou_num0';
	$i = 0;
	
	while(isset($_POST["$val"])){
		$val = 'cou_num'.$i;
		$i++;
	}
	
	echo $val;
	
	
	
	
} else if(isset($_POST['modif']) && $_POST['modif']!=''){
	echo "Bienvenue dans modif";	
}









 /*if (isset($_POST['actual_num_cour']) && $_POST['actual_num_cour']!=''){
echo '<script type=\"text/javascript\"> '. "alert(".$_POST['actual_num_cour'].");" . ' </script>';
 $num = $_POST['actual_num_cour'];

    $req2 ="DELETE FROM TDF_COUREUR
        WHERE TDF_COUREUR.N_COUREUR = '. $num .'";
    $cur2 = PreparerRequeteOCI($conn, $req2);
    $res2 = ExecuterRequeteOCI($cur2);
    ValiderTransacOCI($conn);
}*/

?>
