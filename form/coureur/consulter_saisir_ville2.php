<?php

require_once("../php_util/connexion.php");


if (isset($_POST['EN'])) {

    include_once("consulter_ville.html");

    echo '<input type="button" value="Retour" OnClick="window.location.href=\'consulter_saisir_ville.php\'"><br>';


    $req10 = "SELECT * FROM ETU2_58.TDF_SPONSOR
              WHERE N_EQUIPE =". $_POST['actual_num_eq'];

    $cur10 = PreparerRequeteOCI($conn, $req10);

    ExecuterRequeteOCI($cur10);

    $nb_ligne10 = LireDonneesOCI1($cur10, $tab10);

    for ($i10=0; $i10<$nb_ligne10; $i10++){
        echo "<table border = \"1\">";
        echo "<tr><th>EQUIPE : ". $tab10[$i10]['NOM'] ."</th></tr>";

        $req11 = "SELECT * FROM TDF_EQUIPE WHERE N_EQUIPE =". $tab10[$i10]['N_EQUIPE'];
        $cur11 = PreparerRequeteOCI($conn, $req11);
        ExecuterRequeteOCI($cur11);
        $nb_ligne11 = LireDonneesOCI1($cur11, $tab11);

        echo "<tr style=\"text-align : center;\"><td> Année de création : ". $tab11[0]['ANNEE_CREATION'] ."</td></tr>";
        if (isset($tab11[0]['ANNEE_DISPARITION'])){
            echo "<tr style=\"text-align : center;\"><td> Année de disparition : ". $tab11[0]['ANNEE_DISPARITION'] ."</td></tr>";
            $annee_disp = $tab11[0]['ANNEE_DISPARITION'];
        }else{
            $annee_disp = date('Y', time());
        }

        $annee_crea = $tab11[0]['ANNEE_CREATION'];
        echo "<br>";

        for ($annee_crea = $tab11[0]['ANNEE_CREATION']; $annee_crea<=$tab11[0]['ANNEE_DISPARITION']; $annee_crea++){
            $req12 = "SELECT count(*) as NOMBRE FROM TDF_PARTI_COUREUR WHERE N_EQUIPE = '". $tab10[$i10]['N_EQUIPE'] ."' AND ANNEE = ". $annee_crea;
            $cur12 = PreparerRequeteOCI($conn, $req12);
            ExecuterRequeteOCI($cur12);
            LireDonneesOCI1($cur12, $tab12);

            if ($tab12[0]['NOMBRE']>0){
                $req12 = "select NOM ||' '|| PRENOM as COUREUR from TDF_PARTI_COUREUR par
                          join TDF_COUREUR cou on cou.N_COUREUR = par.N_COUREUR
                          where n_equipe='". $tab10[$i10]['N_EQUIPE'] ."' and ANNEE=".$annee_crea;
                $cur12 = PreparerRequeteOCI($conn, $req12);
                ExecuterRequeteOCI($cur12);
                $nb_ligne12 = LireDonneesOCI1($cur12, $tab12);

                echo "<tr style=\"align : center;\"><td style=\"align : center;\"><table border = \"1\">";
                echo "<tr><th>PARTICIPANTS L'ANNEE : ". $annee_crea ."</th></tr>";

                for($participants=0; $participants<$nb_ligne12; $participants++){
                    echo "<tr style=\"align : center;\"><td>". $tab12[$participants]['COUREUR'] ."</td></tr>";
                }
                echo"</table></td></tr>";
            }

        }

        echo "</table>";
    }

    echo "</body>
        </html>";

} else {
  include_once("consulter_saisir_ville.html");
}



?>
