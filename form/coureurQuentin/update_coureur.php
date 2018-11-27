 <?php

require_once("../php_util/connexion.php");
require_once("../php_util/verif_form.php");

if (isset($_POST['MO'])) { // Si on a appuyé sur le bouton Modifier
    $prenom = '';
	$nom = '';
	$nai = '';
	$apr = '';
	
	
    if (!empty($_POST['cou_pre'])) {
        try {
            echo 'PRENOM<br>';
            echo $_POST['cou_pre'] . ' -> ';
            $prenom = prenom($_POST['cou_pre']);
            echo $prenom;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
        echo '<br><br><br>';
    }
    
    if (!empty($_POST['cou_nom'])) {
        try {
            echo 'NOM<br>';
            echo $_POST['cou_nom'] . ' -> ';
            $nom = nom($_POST['cou_nom']);
            echo $nom;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
        echo '<br><br><br>';
    }
    
    if (!empty($_POST['cou_nai'])) {
        try {
            echo 'Naissance<br>';
            echo $_POST['cou_nai'] . ' -> ';
            $nai = dateNaissance($_POST['cou_nai']);
            echo $nai;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
        echo '<br><br><br>';
    }
    
    if (!empty($_POST['cou_apr'])) {
        try {
            echo 'Première participation<br>';
            echo $_POST['cou_apr'] . ' -> ';
            $apr = datePremierePart($_POST['cou_apr'], $_POST['cou_nai']);
            echo $apr;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
        echo '<br><br><br>';
    }
    
    $req_upd = "UPDATE TDF_COUREUR SET
             NOM = '" . $nom . "',
             PRENOM = '" . $prenom . "',
             ANNEE_NAISSANCE = '" . $nai . "',
             ANNEE_PREM = '" . $apr . "'
             WHERE N_COUREUR = " . $_POST["actual_num_cour_m"];
    $cur_upd = PreparerRequeteOCI($conn, $req_upd);
    $res_upd = ExecuterRequeteOCI($cur_upd);
    
    
    $req_upd2 = "UPDATE TDF_APP_NATION SET
             CODE_CIO = '" . $_POST["cou_nat"] . "'
             WHERE N_COUREUR = " . $_POST["actual_num_cour_m"];
    $cur_upd2 = PreparerRequeteOCI($conn, $req_upd2);
    $res_upd2 = ExecuterRequeteOCI($cur_upd2);
    ValiderTransacOCI($conn);
    
    
    echo ' <h4>Modifications effectuées</h4>

    <input type="button" value="Retour à la consultation/modification/suppression d\'un coureur" onClick="javascript:document.location.href=\'consulter_coureur.php\'">';
} else {
    include("update_coureur.html");
}
?> 