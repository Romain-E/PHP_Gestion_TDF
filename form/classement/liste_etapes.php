<?php
require_once ("../php_util/connexion.php");
include_once ("liste_etapes.html");

$annee_recherchee = $_POST['annee_recherchee'];

if(isset($_POST['annee_recherchee'])) {

//////////TABLEAU CLASSEMENT////////////
$req2 = "select n_epreuve, ville_d, ville_a, distance, jour
		 from tdf_etape
		 where annee = " . $annee_recherchee . "
		 order by n_epreuve";
$cur2 = PreparerRequeteOCI($conn, $req2);
ExecuterRequeteOCI($cur2);
$nb_epreuves = LireDonneesOCI1($cur2, $tab2);

echo '<center><table border="8" name="tabEtapes">
		<tr>
		<th>Numéro</th>
		<th>Ville de départ</th>
		<th>Ville d\'arrivée</th>
		<th>Distance</th>
		<th>Date</th>
		<th>Consulter</th>
		</tr>';


		for ($i=0;$i<$nb_epreuves;$i++) {

			  echo '
			  <tr>
			  <td align="center">' . $tab2[$i]["N_EPREUVE"] . '</td>
			  <td align="center">' . $tab2[$i]["VILLE_D"] . '</td>
			  <td align="center">' . $tab2[$i]["VILLE_A"] . '</td>
			  <td align="center">' . $tab2[$i]["DISTANCE"] . ' km</td>
			  <td align="center">' . $tab2[$i]["JOUR"] . '</td>
				<form action="classement_epreuve.php" method="post">
				<input type="hidden" value="' . $tab2[$i]["N_EPREUVE"] . '" name="num_epreuve">
				<input type="hidden" value="' . $annee_recherchee . '" name="annee_recherchee">
				<td align="center"><input type="submit" value="👁"></td>
				</form>
			  </tr>';
		}





}

  // close connection
  FermerConnexionOCI($conn);

?>
