<?php
require_once ("../php_util/connexion.php");
include_once ("consulter_participant.html");

if(isset($_POST['EN']) && $_POST['annee_recherchee'] != '') {

  require_once ("../php_util/verif_form.php");
  $annee_recherchee = $_POST['annee_recherchee'];
  if(!is_numeric($annee_recherchee)) {
    echo "Ceci n'est pas une année.";
  }
  else {

    /////////////TABLEAU PARTICIPANTS//////////////
    $req1 = "select cou.nom, prenom, spo.nom as nom_sponsor, n_dossard
    from tdf_coureur cou
    join tdf_temps using (n_coureur)
    join tdf_parti_coureur using (n_coureur, annee)
    join tdf_sponsor spo using (n_equipe, n_sponsor)
    left join tdf_temps_difference using (n_coureur, annee)
    where (n_coureur, annee) not in
    (
      select n_coureur, annee from tdf_abandon
      )
      and annee='$annee_recherchee' and valide = 'O'
      group by annee, cou.nom, prenom, spo.nom, difference, to_char(n_coureur), n_dossard
      order by n_dossard";
      $cur1 = PreparerRequeteOCI($conn, $req1);
      ExecuterRequeteOCI($cur1);
      $nb_annees = LireDonneesOCI1($cur1, $tab1);


      if($nb_annees > 0){

        echo '<center><table border="8" id="monTableau" name="tabClassement">
        <tr>
        <th>N° Dossard</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Sponsor</th>
        </tr>';


        for ($i=0;$i<$nb_annees;$i++) {

          echo '
          <tr>
          <td align="center">' . $tab1[$i]["N_DOSSARD"] . '</td>
          <td align="center">' . $tab1[$i]["NOM"] . '</td>
          <td align="center">' . $tab1[$i]["PRENOM"] . '</td>
          <td align="center">' . $tab1[$i]["NOM_SPONSOR"] . '</td>
          </tr>';
        }
      }

      ///////////TABLEAU ABANDON////////////////
      $req2 = "select cou.nom as nom, cou.prenom as prenom, spo.nom as nom_sponsor, n_dossard
      from tdf_coureur cou
      join tdf_temps using (n_coureur)
      join tdf_parti_coureur using (n_coureur, annee)
      join tdf_sponsor spo using (n_equipe, n_sponsor)
      left join tdf_temps_difference using (n_coureur, annee)
      where (n_coureur) in
      (
        select n_coureur from tdf_abandon where annee = '$annee_recherchee'
        )
        and annee='$annee_recherchee' and valide = 'O'
        group by annee, n_coureur, cou.nom, prenom, spo.nom, difference, to_char(n_coureur), n_coureur, cou.prenom, n_dossard
        order by n_dossard";
        $cur2 = PreparerRequeteOCI($conn, $req2);
        ExecuterRequeteOCI($cur2);
        $nb_annees2 = LireDonneesOCI1($cur2, $tab2);


        if($nb_annees2 > 0){

          echo '<center><br><table border="8" id="monTableau" name="tabClassement">
          <tr>
          <th>N° dossard</th>
          <th>Nom</th>
          <th>Prenom</th>
          <th>Sponsor</th>
          </tr>';


          for ($j=0;$j<$nb_annees2;$j++) {

            echo '
            <tr>
            <td align="center">' . $tab2[$j]["N_DOSSARD"] . '</td>
            <td align="center">' . $tab2[$j]["NOM"] . '</td>
            <td align="center">' . $tab2[$j]["PRENOM"] . '</td>
            <td align="center">' . $tab2[$j]["NOM_SPONSOR"] . '</td>
            </tr>';
          }
        }

        echo "</center>";

        if($nb_annees == 0){
          echo "Il n'y a pas de tour de France enregistré pour cette année !";
        }
      }
    }

    // close connection
    FermerConnexionOCI($conn);

    ?>
