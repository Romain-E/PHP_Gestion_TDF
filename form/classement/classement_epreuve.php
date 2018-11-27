<?php
require_once ("../php_util/connexion.php");
include_once ("classement_epreuve.html");

if(isset($_POST['num_epreuve'])) {

	$annee_recherchee =	$_POST['annee_recherchee'];
	$num_epreuve = $_POST['num_epreuve'];

	///////////TABLEAU CLASSEMENT EPREUVE/////////////
	$req3 =  "select rownum as classement, n_epreuve,  n_coureur,nom, prenom, nom_sponsor, TEMPS_TOTAL
	from
	(
		select to_char(n_coureur) as n_coureur, n_epreuve, cou.nom, prenom, spo.nom as nom_sponsor, sum(total_seconde) as temps_total
		from tdf_coureur cou
		join tdf_temps tem using (n_coureur)
		join tdf_parti_coureur using (n_coureur, annee)
		join tdf_sponsor spo using (n_equipe, n_sponsor)
		left join tdf_temps_difference using (n_coureur, annee)
		where (n_coureur, annee) not in
		(
			select n_coureur, annee from tdf_abandon
			)
			and annee=".$annee_recherchee." and valide = 'O' and n_epreuve = ".$num_epreuve."
			group by annee, n_coureur, n_epreuve, cou.nom, prenom,spo.nom, difference
			order by TEMPS_TOTAL
			)";
			$cur3 = PreparerRequeteOCI($conn, $req3);
			ExecuterRequeteOCI($cur3);
			$nb_etapes = LireDonneesOCI1($cur3, $tab3);

			if($nb_etapes > 0){

				echo '<center><table border="8" id="monTableau" name="tabClassement">
				<tr>
				<th>Rang</th>
				<th>Nom</th>
				<th>Prenom</th>
				<th>Sponsor</th>
				<th>Temps</th>
				</tr>';


				for ($i=0;$i<$nb_etapes;$i++) {

					$secondes = $tab3[$i]["TEMPS_TOTAL"];
					$temp = $secondes % 3600;
					$time[0] = ( $secondes - $temp ) / 3600;
					$time[2] = $temp % 60 ;
					$time[1] = ( $temp - $time[2] ) / 60;

					echo '
					<tr>
					<td align="center">' . $tab3[$i]["CLASSEMENT"] . '</td>
					<td align="center">' . $tab3[$i]["NOM"] . '</td>
					<td align="center">' . $tab3[$i]["PRENOM"] . '</td>
					<td align="center">' . $tab3[$i]["NOM_SPONSOR"] . '</td>
					<td align="center">' . $time[0] . 'h ' . $time[1] . 'm ' . $time[2] . 's' . '</td>
					</tr>';
				}
			}

			////////////TABLEAU ABANDON EPREUVE///////////////
			$req4 =  "select rownum as classement, n_epreuve,  n_coureur,nom, prenom, nom_sponsor, TEMPS_TOTAL
			from
			(
				select to_char(n_coureur) as n_coureur, n_epreuve, cou.nom, prenom, spo.nom as nom_sponsor, sum(total_seconde) as temps_total
				from tdf_coureur cou
				join tdf_temps tem using (n_coureur)
				join tdf_parti_coureur using (n_coureur, annee)
				join tdf_sponsor spo using (n_equipe, n_sponsor)
				left join tdf_temps_difference using (n_coureur, annee)
				where (n_coureur, annee, tem.N_EPREUVE) in
				(
					select n_coureur, annee,tem.N_EPREUVE
					from tdf_abandon
					where n_epreuve = ".$num_epreuve."
					)
					and annee=".$annee_recherchee." and valide = 'O' and n_epreuve = 1
					group by annee, n_coureur, n_epreuve, cou.nom, prenom, spo.nom, difference, to_char(n_coureur)
					order by TEMPS_TOTAL)";
					$cur4 = PreparerRequeteOCI($conn, $req4);
					ExecuterRequeteOCI($cur4);
					$nb_etapes2 = LireDonneesOCI1($cur4, $tab4);

					if($nb_etapes2 > 0){

						echo '<center><table border="8" id="monTableau" name="tabClassement">
						<tr>
						<th>Ordre abandon</th>
						<th>Nom</th>
						<th>Prenom</th>
						<th>Sponsor</th>
						<th>Temps</th>
						</tr>';


						for ($j=0;$j<$nb_etapes2;$j++) {

							$secondes = $tab4[$j]["TEMPS_TOTAL"];
							$temp = $secondes % 3600;
							$time[0] = ( $secondes - $temp ) / 3600;
							$time[2] = $temp % 60 ;
							$time[1] = ( $temp - $time[2] ) / 60;

							echo '
							<tr>
							<td align="center">' . $tab4[$j]["CLASSEMENT"] . '</td>
							<td align="center">' . $tab4[$j]["NOM"] . '</td>
							<td align="center">' . $tab4[$j]["PRENOM"] . '</td>
							<td align="center">' . $tab4[$j]["NOM_SPONSOR"] . '</td>
							<td align="center">' . $time[0] . 'h ' . $time[1] . 'm ' . $time[2] . 's' . '</td>
							</tr>';
						}
					} else {
						echo "Il n'y a pas eu d'abandon pour l'épreuve $num_epreuve du tour de France $annee_recherchee";
					}

				}

				// close connection
				FermerConnexionOCI($conn);

				?>
