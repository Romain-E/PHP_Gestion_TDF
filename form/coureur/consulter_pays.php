<?php
require_once ("../php_util/connexion.php");
include_once ("consulter_pays.html");

echo '<center>
        <select name="actual_code_nat">';
$req = "SELECT CODE_CIO, NOM FROM TDF_NATION order by NOM";
$cur = PreparerRequeteOCI($conn, $req);
ExecuterRequeteOCI($cur);
$nb_ligne = LireDonneesOCI1($cur, $tab);

for($i = 0; $i < $nb_ligne;$i++) {
    echo "<option value='".$tab[$i]['CODE_CIO']."'>".$tab[$i]['NOM']."</option>";
}
echo '</select>
        <input type="submit" value="Chercher" name="VALIDE">
    </center>';

if(isset($_POST['VALIDE'])){

    //On vérifie si la nation a déjà participé
    $reqVERIF = "select count(*) as PARTICIPATION from TDF_APP_NATION
    join TDF_PARTI_COUREUR using (N_COUREUR)
    join TDF_NATION using (CODE_CIO)
    where code_cio='". $_POST['actual_code_nat'] ."'";

    $curVERIF = PreparerRequeteOCI($conn, $reqVERIF);

    ExecuterRequeteOCI($curVERIF);

    LireDonneesOCI1($curVERIF, $tabVERIF);

    //echo $tabVERIF[0]['PARTICIPATION'];

    if($tabVERIF[0]['PARTICIPATION']>0){
        //echo $_POST['actual_code_nat'];
        //Nombre de participation par année
        $req10 = "select par.ANNEE as ANNEE_NAT, nat.NOM as NOM_NAT, nat.CODE_CIO as CODE, count(*) as NB_PARTICIPATION from TDF_APP_NATION app
        join TDF_NATION nat on nat.CODE_CIO = app.CODE_CIO
        join TDF_PARTI_COUREUR par on par.N_COUREUR = app.N_COUREUR
        HAVING nat.CODE_CIO = '". $_POST['actual_code_nat'] ."'
        GROUP BY par.ANNEE, nat.NOM, nat.CODE_CIO
        ORDER BY par.ANNEE";

        $cur10 = PreparerRequeteOCI($conn, $req10);

        ExecuterRequeteOCI($cur10);

        $nb_ligne10 = LireDonneesOCI1($cur10, $tab10);


        //Nombre total de participations

        $req11= "select nat.CODE_CIO as CODE, nat.NOM as NOM_NAT, count(*) as NB_PARTICIPATION_TOT from TDF_APP_NATION app
        join TDF_NATION nat on nat.CODE_CIO = app.CODE_CIO
        join TDF_PARTI_COUREUR par on par.N_COUREUR = app.N_COUREUR
        HAVING nat.CODE_CIO = '". $_POST['actual_code_nat'] ."'
        GROUP BY nat.NOM, nat.CODE_CIO";

        $cur11 = PreparerRequeteOCI($conn, $req11);

        ExecuterRequeteOCI($cur11);

        $nb_ligne11 = LireDonneesOCI1($cur11, $tab11);

        echo "<h6>Nombre de participations totales : ". $tab11[0]['NB_PARTICIPATION_TOT'] .".</h6>";

        echo "<table border = \"1\">";
        echo "<tr><th colspan=\"2\">PAYS : ". $tab10[0]['NOM_NAT'] ."</th></tr>";
        echo "<tr><th>Année</th><th>Nombre de participations</th></tr>";
        for($i=0; $i<$nb_ligne10; $i++){
            echo "<tr><td>". $tab10[$i]['ANNEE_NAT'] ."</td><td>". $tab10[$i]['NB_PARTICIPATION'] ."</td></tr>";
        }
    }else{
        $req12 = "select NOM from TDF_NATION
        WHERE CODE_CIO = '". $_POST['actual_code_nat'] ."'";

        $cur12 = PreparerRequeteOCI($conn, $req12);

        ExecuterRequeteOCI($cur12);

        LireDonneesOCI1($cur12, $tab12);


        echo "<h4>PAYS : ". $tab12[0]['NOM'] ."</h4>";
        echo "<h6>Nombre de participations totales : 0.</h6>";
    }


}

echo '</table></form>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<body>
<html>';


?>
