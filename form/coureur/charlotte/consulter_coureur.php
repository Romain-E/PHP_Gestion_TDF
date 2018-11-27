<?php
require_once ("../../php_util/connexion.php");
//require_once("suppr_coureur.php");

if(isset($_POST['actual_num_cour'])){
    //echo '<script type=\"text/javascript\"> '. "alert(".print_r($_POST).");" . ' </script>';

    echo ' <form action="suppr_coureur.php" method="post"> 
 
 Voulez-vous vraiment supprimer le coureur '. $_POST['actual_num_cour'] .' ? </br>
 
 <button type="submit">Valider</button>
 </form>
 
 <button onClick="javascript:document.location.href=\'consulter_coureur.php\'">Annuler</button>';

}



    include_once ("consulter_coureur.html");
	$where="";
	
	if(isset($_POST['cou_nom_recherche']) && $_POST['cou_nom_recherche']!=""){
		$where=" WHERE cou.NOM LIKE upper('". $_POST['cou_nom_recherche'] ."%')";
	}

	
	print_r($_POST);	
	$tri="";
	
	if(isset($_POST['cou_num_tri'])){
		if($_POST['cou_num_tri']=='croissant'){
			$tri = $tri . ", cou.N_COUREUR ";
		}else if($_POST['cou_num_tri']=='decroissant'){
			$tri = $tri . ", cou.N_COUREUR desc";
		}
	}
	
	if(isset($_POST['cou_nom_tri'])){
		if($_POST['cou_nom_tri']=='croissant'){
			$tri = $tri . ", cou.NOM ";
		}else if($_POST['cou_nom_tri']=='decroissant'){
			$tri = $tri . ", cou.NOM desc";
		}
	}
	
	if(isset($_POST['cou_pre_tri'])){
		if($_POST['cou_pre_tri']=='croissant'){
			$tri = $tri . ", PRENOM ";
		}else if($_POST['cou_pre_tri']=='decroissant'){
			$tri = $tri . ", PRENOM desc";
		}
	}
	
	if(isset($_POST['cou_nai_tri'])){
		if($_POST['cou_nai_tri']=='croissant'){
			$tri = $tri . ", ANNEE_NAISSANCE ";
		}else if($_POST['cou_nai_tri']=='decroissant'){
			$tri = $tri . ", ANNEE_NAISSANCE desc";
		}
	}
	
	if(isset($_POST['cou_par_tri'])){
		if($_POST['cou_par_tri']=='croissant'){
			$tri = $tri . ", ANNEE_PREM ";
		}else if($_POST['cou_par_tri']=='decroissant'){
			$tri = $tri . ", ANNEE_PREM desc";
		}
	}
	
	if(isset($_POST['cou_nat_tri'])){
		if($_POST['cou_nat_tri']=='croissant'){
			$tri = $tri . ", pays.NOM ";
		}else if($_POST['cou_nat_tri']=='decroissant'){
			$tri = $tri . ", pays.NOM desc";
		}
	}
	
	
	
// Prepare un select
    $req = "SELECT cou.N_COUREUR, cou.NOM as NOM_COUREUR, PRENOM, ANNEE_NAISSANCE, ANNEE_PREM, pays.NOM as NOM_PAYS
        FROM TDF_COUREUR cou
        JOIN TDF_APP_NATION nat ON nat.N_COUREUR=cou.N_COUREUR
        JOIN TDF_NATION pays ON pays.CODE_CIO=nat.CODE_CIO"
		. $where ."
		ORDER BY null ". $tri;
    $cur = PreparerRequeteOCI($conn, $req);
	//$res = ajouterParamOCI($cur, $tri_final, $tri, 88);
	
	echo "<br>$req<br>";
	
    ExecuterRequeteOCI($cur);

    $nb_ligne = LireDonneesOCI1($cur, $tab);

    if($nb_ligne > 0){

        echo '<table border="1" id="monTableau" name="tabCoureurs">
  <tr>
      <th>Numéro</th>
      <th>Nom</th>
      <th>Prenom</th>
      <th>Annee de naissance</th>
      <th>Année de première participation</th>
      <th>Nationalité</th>
      <th>SUPPRIMER</th>
      <th>MODIFIER</th>
  </tr>';

        for ($i=0;$i<$nb_ligne;$i++) {
            echo '
                        <tr>
                            <td align="center" id="num_cou" value="num_cou">'.$tab[$i]["N_COUREUR"].'</td>
                            <td align="center">'.$tab[$i]["NOM_COUREUR"].'</td>
                            <td align="center">'.$tab[$i]["PRENOM"].'</td>
                            <td align="center">'.$tab[$i]["ANNEE_NAISSANCE"].'</td>
                            <td align="center">'.$tab[$i]["ANNEE_PREM"].'</td>
                            <td align="center">'.$tab[$i]["NOM_PAYS"].'</td>
                            <td align="center"><button onclick="suppr('. $tab[$i]["N_COUREUR"] .')">-</button></td>
                            <td align="center"><button onClick="modif()">~</button></td>
                        </tr>';
        }
        echo '</table></div>';




        $erreur = false;

        if(isset($_REQUEST["term"])){



            if (!empty($_POST['tst'])){
                echo $_POST['tst'];
            }



            if($cur = PreparerRequeteOCI($conn, $req)){

                // Bind variables to the prepared statement as parameters
                ajouterParamOCI($cur, ":search", $param_term, 200);

                // Set parameters
                $param_term = $_REQUEST["term"] . '%';

                // Tentative d'execution
                if(ExecuterRequeteOCI($cur)){

                } else{
                    echo "<p>No matches found</p>";
                }
            } else{
                //echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            }
        }
    }





// close connection
FermerConnexionOCI($conn);

?>