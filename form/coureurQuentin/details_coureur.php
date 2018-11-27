<?php 
require_once ("../php_util/connexion.php");
include_once ('details_coureur.html');


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
		 where n_coureur = '". $_POST['num_cour_actuel'] ."'
		 group by n_coureur";
$cur1 = PreparerRequeteOCI($conn, $req1);
ExecuterRequeteOCI($cur1);
$nb_annees = LireDonneesOCI1($cur1, $tab1);

//Tableau avec toutes les années du coureur
$req2 = "select ANNEE from tdf_parti_coureur
		 where n_coureur = '". $_POST['num_cour_actuel'] ."'";
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
for($i = 0; $i < $tab1[0]['ANNEE']; $i++){
    echo "<table border=\"1\">";
    echo "<tr><th>ANNEE : ". $tab2[$i]['ANNEE'] ."</th></tr>";
	$req3 = "select N_EQUIPE, NOM as EQ_NOM from TDF_PARTI_COUREUR
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

    echo '<tr><td><button onclick="equipe('. $tab3[0]['N_EQUIPE'] .')">Equipe : '. $tab3[0]['EQ_NOM'] .'</button></td></tr>';


    //echo "<tr><td>Equipe : ". $tab3[0]['EQ_NOM'] ."</td></tr>";

    echo "</table><br>";
}

echo "</div>
        </body>
        </html>";
?>