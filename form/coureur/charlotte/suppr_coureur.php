<?php
require_once ("../../php_util/connexion.php");


echo '<script type=\"text/javascript\"> '. 'alert("test");' . ' </script>';
echo '<script type=\"text/javascript\"> '. "alert(".print_r($_POST).");" . ' </script>';
if (isset($_POST['actual_num_cour']) && $_POST['actual_num_cour']!=''){
echo '<script type=\"text/javascript\"> '. "alert(".$_POST['actual_num_cour'].");" . ' </script>';
 $num = $_POST['actual_num_cour'];
 
    $req2 ="DELETE FROM TDF_COUREUR
        WHERE TDF_COUREUR.N_COUREUR = '. $num .'";
    $cur2 = PreparerRequeteOCI($conn, $req2);
    $res2 = ExecuterRequeteOCI($cur2);
    ValiderTransacOCI($conn);*/
}


?>
