<?php


  require_once ("../php_util/connexion.php");

  include_once ("consulter_coureur.html");
  $where="";

  if(isset($_POST['cou_nom_recherche']) && $_POST['cou_nom_recherche']!=""){
    $where=" WHERE cou.NOM LIKE upper('". $_POST['cou_nom_recherche'] ."%')";
  }

  $tri="";

if(isset($_POST['triage'])) {
	foreach($_POST['triage'] as $i) {
	if (isset($_POST['cou_num_tri']) && $i == 'numero') {
		if ($_POST['cou_num_tri'] == 'croissant') {
			$tri = $tri . ", cou.N_COUREUR asc";
		}
		else
		if ($_POST['cou_num_tri'] == 'decroissant') {
			$tri = $tri . ", cou.N_COUREUR desc";
		}
	}

	if (isset($_POST['cou_nom_tri']) && $i == 'nom') {
		if ($_POST['cou_nom_tri'] == 'croissant') {
			$tri = $tri . ", cou.NOM asc";
		}
		else
		if ($_POST['cou_nom_tri'] == 'decroissant') {
			$tri = $tri . ", cou.NOM desc";
		}
	}

	if (isset($_POST['cou_pre_tri']) && $i == 'prenom') {
		if ($_POST['cou_pre_tri'] == 'croissant') {
			$tri = $tri . ", PRENOM asc";
		}
		else
		if ($_POST['cou_pre_tri'] == 'decroissant') {
			$tri = $tri . ", PRENOM desc";
		}
	}

	if (isset($_POST['cou_nai_tri']) && $i == 'naissance') {
		if ($_POST['cou_nai_tri'] == 'croissant') {
			$tri = $tri . ", ANNEE_NAISSANCE asc";
		}
		else
		if ($_POST['cou_nai_tri'] == 'decroissant') {
			$tri = $tri . ", ANNEE_NAISSANCE desc";
		}
	}

	if (isset($_POST['cou_par_tri']) && $i == 'premierepart') {
		if ($_POST['cou_par_tri'] == 'croissant') {
			$tri = $tri . ", ANNEE_PREM asc";
		}
		else
		if ($_POST['cou_par_tri'] == 'decroissant') {
			$tri = $tri . ", ANNEE_PREM desc";
		}
	}

	if (isset($_POST['cou_nat_tri']) && $i == 'nationalite') {
		if ($_POST['cou_nat_tri'] == 'croissant') {
			$tri = $tri . ", pays.NOM asc";
		}
		else
		if ($_POST['cou_nat_tri'] == 'decroissant') {
			$tri = $tri . ", pays.NOM desc";
		}
	}
}
echo $tri;
}

  
  

  if(isset($_POST['actual_num_cour'])){

      // Récupération des infos du coureur
      $req = "SELECT cou.N_COUREUR, cou.NOM as NOM_COUREUR, PRENOM, ANNEE_NAISSANCE, ANNEE_PREM, pays.NOM as NOM_PAYS
        FROM TDF_COUREUR cou
        JOIN TDF_APP_NATION nat ON nat.N_COUREUR=cou.N_COUREUR
        JOIN TDF_NATION pays ON pays.CODE_CIO=nat.CODE_CIO
        WHERE cou.N_COUREUR =".$_POST['actual_num_cour'];
      $cur = PreparerRequeteOCI($conn, $req);

      ExecuterRequeteOCI($cur);

      $nb1 = LireDonneesOCI1($cur, $tab_suppr);

      if (empty($tab_suppr[0]["ANNEE_PREM"])){
          echo ' <form action="suppr_coureur.php" method="post">
          <h4 style="text-align:center;">Confirmation de suppression</h4>
          <p style="text-align:center;">Voulez-vous vraiment supprimer le coureur '. $_POST['actual_num_cour'] .' ? </br>
          Nom : '.$tab_suppr[0]["NOM_COUREUR"].'<br>
          Prénom : '.$tab_suppr[0]["PRENOM"].'<br>
          Nationalité : '.$tab_suppr[0]["NOM_PAYS"].'<br></p>
          <input type="hidden" name="cou_num_suppr" value="' . $_POST['actual_num_cour'] . '">
          <center><button type="submit">Valider</button></center>
      
          </form>
      
          <center><button onClick="javascript:document.location.href=\'consulter_coureur.php\'">Annuler</button></center><br>';
      }else{
          echo '<p style="text-align:center;">Le coureur '. $_POST['actual_num_cour'] .' ne peut être supprimé car il a <b>déjà participé</b> à un tour de France. </br>
          Nom : '.$tab_suppr[0]["NOM_COUREUR"].'<br>
          Prénom : '.$tab_suppr[0]["PRENOM"].'<br>
          Année de première participation : '.$tab_suppr[0]["ANNEE_PREM"].' <br>
          Nationalité : '.$tab_suppr[0]["NOM_PAYS"].'<br></p>';
      }
  }

  if(isset($_POST['actual_num_cour_m'])){

    echo ' <form action="update_coureur.php" method="post">

    Voulez-vous vraiment modifier le coureur '. $_POST['actual_num_cour_m'] .' ? </br>
    <input type="hidden" name="cou_num_modif" value="' . $_POST['actual_num_cour_m'] . '">
    <button type="submit">Valider</button>

    </form>

    <button onClick="javascript:document.location.href=\'consulter_coureur.php\'">Annuler</button>';

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

  //echo "<br>$req<br>";

  ExecuterRequeteOCI($cur);

  $nb_ligne = LireDonneesOCI1($cur, $tab);

  if($nb_ligne > 0){

    echo '<center><table border="8" id="monTableau" name="tabCoureurs">
    <tr>
    <th>Numéro</th>
    <th>Nom</th>
    <th>Prenom</th>
    <th>Annee de naissance</th>
    <th>Année de première participation</th>
    <th>Nationalité</th>
    <th>SUPPRIMER</th>
    <th>MODIFIER</th>
    <th>DETAILS</th>
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
      <td align="center"><button onclick="suppr('. $tab[$i]["N_COUREUR"] .')">✖</button></td>
      <td align="center"><button onclick="modif('. $tab[$i]["N_COUREUR"] .')">🖉</button></td>
      <form action="details_coureur.php" method="post" enctype="application/x-www-form-urlencoded">
      <input type="hidden" name="num_cour_actuel" value='. $tab[$i]["N_COUREUR"] .'>
      <td align="center"><button onclick="submit">👁</button></td>
      </form>
      </tr>';
    }
    echo '</table></center></div>';




    $erreur = false;

    if(isset($_REQUEST["term"])){



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
