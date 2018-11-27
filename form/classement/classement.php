<?php
require_once ("../php_util/connexion.php");
include_once ("classement.html");

if(isset($_POST['EN']) && $_POST['annee_recherchee'] != '') {

	require_once ("../php_util/verif_form.php");
	$annee_recherchee = $_POST['annee_recherchee'];
	if(!is_numeric($annee_recherchee)) {
		echo "Ceci n'est pas une année.";
	}
	else {
		//Bouton étape
		echo "	<form action='liste_etapes.php' method='post'>
		<center><br><button type='submit' name='annee_recherchee' value='".$annee_recherchee."'>Détails des étapes</button></center><br>
		</form>";
		/////////////TABLEAU CLASSEMENT//////////////
		$req1 = "select annee, rownum as classement, n_coureur,nom, prenom, nom_sponsor, TEMPS_TOTAL from
		(
			select annee, to_char(n_coureur) as n_coureur, cou.nom, prenom, spo.nom as nom_sponsor, sum(total_seconde) + nvl(difference,0) as temps_total
			from tdf_coureur cou
			join tdf_temps using (n_coureur)
			join tdf_parti_coureur using (n_coureur, annee)
			join tdf_sponsor spo using (n_equipe, n_sponsor)
			left join tdf_temps_difference using (n_coureur, annee)
			where (n_coureur, annee) not in
			(
				select n_coureur, annee from tdf_abandon
			)
			and annee=" . $annee_recherchee . " and valide = 'O'
			group by annee, n_coureur, cou.nom, prenom,spo.nom, difference
			union
			select annee, '------', substr(cou.nom,1,2) || '----', substr(prenom,1,2) || '----', spo.nom as nom_sponor, sum(total_seconde) + nvl(difference,0) as TEMPS_TOTAL
			from tdf_coureur cou
			join tdf_temps using (n_coureur)
			join tdf_parti_coureur using (n_coureur, annee)
			join tdf_sponsor spo using (n_equipe, n_sponsor)
			left join tdf_temps_difference using (n_coureur, annee)
			where (n_coureur, annee) not in
			(
				select n_coureur, annee from tdf_abandon
			)
			and annee=" . $annee_recherchee . " and valide = 'R'
			group by annee, cou.nom, prenom,spo.nom, difference
			order by TEMPS_TOTAL
		  )";
					$cur1 = PreparerRequeteOCI($conn, $req1);
					ExecuterRequeteOCI($cur1);
					$nb_annees = LireDonneesOCI1($cur1, $tab1);


					if($nb_annees > 0){

						echo '<center><table border="8" id="monTableau" name="tabClassement">
						<tr>
						<th>Rang</th>
						<th>Nom</th>
						<th>Prenom</th>
						<th>Sponsor</th>
						<th>Temps</th>
						</tr>';


						for ($i=0;$i<$nb_annees;$i++) {



							$secondes = $tab1[$i]["TEMPS_TOTAL"];
							$temp = $secondes % 3600;
							$time[0] = ( $secondes - $temp ) / 3600;
							$time[2] = $temp % 60 ;
							$time[1] = ( $temp - $time[2] ) / 60;

							echo '
							<tr>
							<td align="center">' . $tab1[$i]["CLASSEMENT"] . '</td>
							<td align="center">' . $tab1[$i]["NOM"] . '</td>
							<td align="center">' . $tab1[$i]["PRENOM"] . '</td>
							<td align="center">' . $tab1[$i]["NOM_SPONSOR"] . '</td>
							<td align="center">' . $time[0] . 'h ' . $time[1] . 'm ' . $time[2] . 's' . '</td>
							</tr>';
						}
					}

					///////////TABLEAU ABANDON////////////////
					$req2 = "select cou.nom as nom, cou.prenom as prenom, spo.nom as nom_sponsor, sum(total_seconde) + nvl(difference,0) as TEMPS_TOTAL
					from tdf_coureur cou
					join tdf_temps using (n_coureur)
					join tdf_parti_coureur using (n_coureur, annee)
					join tdf_sponsor spo using (n_equipe, n_sponsor)
					left join tdf_temps_difference using (n_coureur, annee)
					where (n_coureur) in
					(
						select n_coureur from tdf_abandon where annee = " . $annee_recherchee . "
						)
						and annee=" . $annee_recherchee . " and valide = 'O'
						group by annee, n_coureur, cou.nom, prenom, spo.nom, difference, to_char(n_coureur)
						order by TEMPS_TOTAL";
						$cur2 = PreparerRequeteOCI($conn, $req2);
						ExecuterRequeteOCI($cur2);
						$nb_annees2 = LireDonneesOCI1($cur2, $tab2);


						if($nb_annees2 > 0){

							echo '<center><table border="8" id="monTableau" name="tabClassement">
							<tr>
							<th>Ordre abandon</th>
							<th>Nom</th>
							<th>Prenom</th>
							<th>Sponsor</th>
							<th>Temps</th>
							</tr>';


							for ($j=0;$j<$nb_annees2;$j++) {



								$secondes = $tab2[$j]["TEMPS_TOTAL"];
								$temp = $secondes % 3600;
								$time[0] = ( $secondes - $temp ) / 3600;
								$time[2] = $temp % 60 ;
								$time[1] = ( $temp - $time[2] ) / 60;

								echo '
								<tr>
								<td align="center">' . ($j + 1) . '</td>
								<td align="center">' . $tab2[$j]["NOM"] . '</td>
								<td align="center">' . $tab2[$j]["PRENOM"] . '</td>
								<td align="center">' . $tab2[$j]["NOM_SPONSOR"] . '</td>
								<td align="center">' . $time[0] . 'h ' . $time[1] . 'm ' . $time[2] . 's' . '</td>
								</tr>';
							}
						}

						if($nb_annees == 0){
							echo "Il n'y a pas de tour de France enregistré pour cette année !";
						}
					}




				}

				// close connection
				FermerConnexionOCI($conn);

				?>
