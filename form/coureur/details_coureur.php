<?php
require_once ("../php_util/connexion.php");
include_once ('details_coureur.html');


echo'<input type="button" name="" value="Retour" onClick="javascript:document.location.href=\'consulter_coureur.php\'">';

// Récupération des infos du coureur
$req_info = "SELECT cou.N_COUREUR, cou.NOM as NOM_COUREUR, PRENOM, ANNEE_NAISSANCE, ANNEE_PREM, pays.NOM as NOM_PAYS
        FROM TDF_COUREUR cou
        JOIN TDF_APP_NATION nat ON nat.N_COUREUR=cou.N_COUREUR
        JOIN TDF_NATION pays ON pays.CODE_CIO=nat.CODE_CIO
        WHERE cou.N_COUREUR =".$_POST['num_cour_actuel'];
$cur_info = PreparerRequeteOCI($conn, $req_info);

ExecuterRequeteOCI($cur_info);

$nb0 = LireDonneesOCI1($cur_info, $tab_info);

echo '    <p>Voici le détail du coureur '. $_POST['num_cour_actuel'] .'</br>
          Nom : '.$tab_info[0]["NOM_COUREUR"].'<br>
          Prénom : '.$tab_info[0]["PRENOM"].'<br>
          Nationalité : '.$tab_info[0]["NOM_PAYS"].'<br></p>';



//Nombre d'années de participation du coureur 
$req1 = "select count(*) as ANNEE from tdf_parti_coureur
		 where n_coureur = ". $_POST['num_cour_actuel'];
$cur1 = PreparerRequeteOCI($conn, $req1);
ExecuterRequeteOCI($cur1);
$nb_annees = LireDonneesOCI1($cur1, $tab1);

//Tableau avec toutes les années du coureur
$req2 = "select ANNEE from tdf_parti_coureur
		 where n_coureur = '". $_POST['num_cour_actuel'] ."' ORDER BY ANNEE";
$cur2 = PreparerRequeteOCI($conn, $req2);

ExecuterRequeteOCI($cur2);

$tab_annees = LireDonneesOCI1($cur2, $tab2);

//echo test
/*echo "<PRE>";
print_r($_POST);
print_r($tab1);
print_r($tab2);
echo "</PRE>";
*/


if ($tab1[0]['ANNEE']>0){
    //affichage des informations par année
    for($i = 0; $i < $tab1[0]['ANNEE']; $i++){

        echo "<table border=\"1\">";
        echo "<tr><th>ANNEE : ". $tab2[$i]['ANNEE'] ."</th></tr>";


        //On affiche l'équipe
        $req3 = "select N_EQUIPE, N_SPONSOR, NOM as EQ_NOM from TDF_PARTI_COUREUR
              join TDF_PARTI_EQUIPE using (ANNEE, N_EQUIPE, N_SPONSOR)
              join TDF_SPONSOR using (N_EQUIPE, N_SPONSOR)
              where ANNEE=". $tab2[$i]['ANNEE'] ." and N_EQUIPE=
              (
                  select n_equipe from TDF_PARTI_COUREUR
                  where n_coureur=". $_POST['num_cour_actuel'] ." and annee=". $tab2[$i]['ANNEE'] ."
              )";
        //echo $req3."<br>";

        $cur3 = PreparerRequeteOCI($conn, $req3);

        ExecuterRequeteOCI($cur3);

        LireDonneesOCI1($cur3, $tab3);

        //echo '<tr style="text-align : center;"><td><button onclick="equipe('. $tab3[0]['N_EQUIPE'] .', '. $_POST['num_cour_actuel'] .')">Equipe : '. $tab3[0]['EQ_NOM'] .'</button></td></tr>';

        echo '<tr style="text-align : center;"><form action="consulter_equipe.php" method="post" enctype="application/x-www-form-urlencoded">
      <input type="hidden" name="actual_num_eq" value='. $tab3[0]['N_EQUIPE'] .'>
      <input type="hidden" name="actual_num_cour" value='. $_POST['num_cour_actuel'] .'>
      <td align="center"><button onClick="submit">Equipe : '. $tab3[0]['EQ_NOM'] .'</button></td>
      </form></tr>';

        //A-t-il abandonné ?

        $req4 = "SELECT count(*) as ABANDON FROM ETU2_58.TDF_ABANDON
              WHERE ANNEE=". $tab2[$i]['ANNEE'] ." and N_COUREUR=". $_POST['num_cour_actuel'];
        //echo $req3."<br>";

        $cur4 = PreparerRequeteOCI($conn, $req4);

        ExecuterRequeteOCI($cur4);

        $nb4 = LireDonneesOCI1($cur4, $tab4);

        if($tab4[0]['ABANDON']>0) {
            $req5 = "SELECT ANNEE, N_EPREUVE FROM ETU2_58.TDF_ABANDON
              WHERE ANNEE=". $tab2[$i]['ANNEE'] ." and N_COUREUR=". $_POST['num_cour_actuel'];

            $cur5 = PreparerRequeteOCI($conn, $req5);

            ExecuterRequeteOCI($cur5);

            $nb5 = LireDonneesOCI1($cur5, $tab5);

            echo '<tr style="text-align : center;"><td>A abandonnée à l\'épreuve numéro ' . $tab5[0]['N_EPREUVE'] . '</td></tr>';
        }else{
            //Classement de cette année
            $req5 = "select * from (select annee, rownum as classement, n_coureur, nom, prenom, TEMPS_TOTAL
                  from (select annee,
                              to_char(n_coureur)                      as n_coureur,
                              nom,
                              prenom,
                              sum(total_seconde) + nvl(difference, 0) as temps_total
                       from tdf_coureur
                              join tdf_temps using (n_coureur)
                              join tdf_parti_coureur using (n_coureur, annee)
                              left join tdf_temps_difference using (n_coureur, annee)
                       where (n_coureur, annee) not in
                             (select n_coureur, annee from tdf_abandon)
                         and annee = ". $tab2[$i]['ANNEE'] ."
                         and valide = 'O'
                       group by annee, n_coureur, nom, prenom, difference
                       union
                       select annee,
                              '------',
                              substr(nom, 1, 2) || '----',
                              prenom,
                              sum(total_seconde) + nvl(difference, 0) as TEMPS_TOTAL
                       from tdf_coureur
                              join tdf_temps using (n_coureur)
                              join tdf_parti_coureur using (n_coureur, annee)
                              left join tdf_temps_difference using (n_coureur, annee)
                       where (n_coureur, annee) not in
                             (select n_coureur, annee from tdf_abandon)
                         and annee = ". $tab2[$i]['ANNEE'] ."
                         and valide = 'R'
                       group by annee, nom, prenom, difference
                       order by TEMPS_TOTAL)
                  ) where n_coureur = '". $_POST['num_cour_actuel'] ."'";

            $cur5 = PreparerRequeteOCI($conn, $req5);

            ExecuterRequeteOCI($cur5);

            $nb5 = LireDonneesOCI1($cur5, $tab5);

            echo '<tr style="text-align : center;"><td>Classement : ' . $tab5[0]['CLASSEMENT'] . '</td></tr>';

            //Son temps

            $secondes = $tab5[0]['TEMPS_TOTAL'];
            $temp = $secondes % 3600;
            $time1[0] = ( $secondes - $temp ) / 3600;
            $time1[2] = $temp % 60 ;
            $time1[1] = ( $temp - $time1[2] ) / 60;

            echo '<tr style="text-align : center;"><td>Temps : '. $time1[0] .' heures '. $time1[1] .' minutes ' . $time1[2] . ' secondes</td></tr>';
        }

        //A-t-il gagné une étape ?

        $req6 = "select count(*) as ETAPE_GAGNEE from TDF_coureur cou where exists
              (
                select 0 from TDF_temps where rang_arrivee = 1
                and n_coureur = cou.n_coureur and ANNEE=". $tab2[$i]['ANNEE'] ."
              ) and cou.n_coureur=". $_POST['num_cour_actuel'];

        $cur6 = PreparerRequeteOCI($conn, $req6);

        ExecuterRequeteOCI($cur6);

        LireDonneesOCI1($cur6, $tab6);

        //Si oui on les affiches toutes
        if ($tab6[0]['ETAPE_GAGNEE']>0){
            $req7="select n_epreuve from tdf_temps where rang_arrivee = 1 and annee = ". $tab2[$i]['ANNEE'] ." and n_coureur = ". $_POST['num_cour_actuel'];
            $cur7 = PreparerRequeteOCI($conn, $req7);

            ExecuterRequeteOCI($cur7);

            $nb7 = LireDonneesOCI1($cur7, $tab7);

            for($i7=0; $i7<$nb7; $i7++){
                echo '<tr style="text-align : center;"><td>A gagné l\'étape : '. $tab7[$i7]['N_EPREUVE'] .'</td></tr>';
            }
            //si non
        }else{
            echo '<tr style="text-align : center;"><td>N\'a gagné aucune étape.</td></tr>';
        }





        //echo "<tr><td>Equipe : ". $tab3[0]['EQ_NOM'] ."</td></tr>";

        echo "</table><br>";
    }
}


echo "</div>
        </body>
        </html>";
?>