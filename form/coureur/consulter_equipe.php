<?php
    require_once ("../php_util/connexion.php");
    include_once ("consulter_equipe.html");

    //echo "Equipe numéro : ".$_POST['actual_num_eq'];

    if (isset($_POST['actual_num_cour'])){
        //echo "Coureur numéro :".$_POST['actual_num_cour'];

        echo '<tr style="text-align : center;"><form action="details_coureur.php" method="post" enctype="application/x-www-form-urlencoded">
          <input type="hidden" name="num_cour_actuel" value='. $_POST['actual_num_cour'] .'>
          <td align="center"><button onClick="submit">Retour</button></td>
          </form></tr>';
    }

    $req10 = "SELECT * FROM TDF_SPONSOR
              WHERE N_EQUIPE =". $_POST['actual_num_eq'] ."
              ORDER BY ANNEE_SPONSOR";

    $cur10 = PreparerRequeteOCI($conn, $req10);

    ExecuterRequeteOCI($cur10);

    $nb_ligne10 = LireDonneesOCI1($cur10, $tab10);

    //infos sur les années d'équipes
    $req11 = "SELECT * FROM TDF_EQUIPE WHERE N_EQUIPE =". $tab10[0]['N_EQUIPE'];
    $cur11 = PreparerRequeteOCI($conn, $req11);
    ExecuterRequeteOCI($cur11);
    $nb_ligne11 = LireDonneesOCI1($cur11, $tab11);

    echo "<h4> Année de création : ". $tab11[0]['ANNEE_CREATION'] ."</h4>";
    if (isset($tab11[0]['ANNEE_DISPARITION'])){
        echo "<h4> Année de disparition : ". $tab11[0]['ANNEE_DISPARITION'] ."</h4>";
        $annee_disp = $tab11[0]['ANNEE_DISPARITION'];
    }else{
        $annee_disp = date('Y', time());
    }

    $annee = $tab11[0]['ANNEE_CREATION'];
    echo "<br>";


    //info sur les coureurs
    for ($annee = $tab11[0]['ANNEE_CREATION']; $annee<=$annee_disp; $annee++){



        $req12 = "SELECT count(*) as NOMBRE FROM TDF_PARTI_COUREUR 
        WHERE N_EQUIPE = '". $tab10[0]['N_EQUIPE'] ."' AND ANNEE = ". $annee;
        $cur12 = PreparerRequeteOCI($conn, $req12);
        ExecuterRequeteOCI($cur12);
        LireDonneesOCI1($cur12, $tab12);

        if ($tab12[0]['NOMBRE']>0){

            $numSponAnnee=0;
            for ($i10=0; $i10<$nb_ligne10; $i10++){
                if($annee >= $tab10[$i10]['ANNEE_SPONSOR']){
                    $numSponAnnee=$i10;
                }
            }

            //echo $numSponAnnee."<br>";

            echo "<table border = \"1\">";
            echo "<tr><th>EQUIPE : ". $tab10[$numSponAnnee]['NOM'] ."</th></tr>";

            $req12 = "select NOM ||' '|| PRENOM as COUREUR from TDF_PARTI_COUREUR par
                      join TDF_COUREUR cou on cou.N_COUREUR = par.N_COUREUR
                      where n_equipe='". $tab10[0]['N_EQUIPE'] ."' and ANNEE=".$annee;
            $cur12 = PreparerRequeteOCI($conn, $req12);
            ExecuterRequeteOCI($cur12);
            $nb_ligne12 = LireDonneesOCI1($cur12, $tab12);

            echo "<tr><th>PARTICIPANTS L'ANNEE : ". $annee ."</th></tr>";

            for($participants=0; $participants<$nb_ligne12; $participants++){
                echo "<tr style=\"align : center;\"><td>". $tab12[$participants]['COUREUR'] ."</td></tr>";
            }
            echo"</table><br>";
        }


    }



    echo "</body>
        </html>"
?>
