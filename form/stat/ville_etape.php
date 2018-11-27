<?php
require_once ("../php_util/connexion.php");
include_once ("ville_etape.html");
require_once ("../php_util/verif_form.php");

if(isset($_POST['EN']) && $_POST['ville_recherchee'] != '') {

  $ville_recherchee=strtoupper($_POST['ville_recherchee']);
	$ville_recherchee = preg_replace("/'/","''",$ville_recherchee);
/////////////TABLEAU PAYS VISITES//////////////
$req1 = "select sum(nb_etape) as nb_etape, nom, code_cio_d, ville_d,code_cio from
(
  select COUNT(*) as nb_etape, ville_d, code_cio_d
  from tdf_etape
  group by ville_d, code_cio_d
  union
  select COUNT(*), ville_a, code_cio_a
  from tdf_etape
  group by ville_a, code_cio_a
  )
  join tdf_nation on code_cio_d=code_cio
  where ville_d like '$ville_recherchee%'
  group by code_cio_d, nom, ville_d,code_cio
  order by ville_d";
  $cur1 = PreparerRequeteOCI($conn, $req1);
  ExecuterRequeteOCI($cur1);
  $nb_etape = LireDonneesOCI1($cur1, $tab1);


  if($nb_etape > 0){

    echo '<center><table border="8">
    <tr>
    <th class="text-align:center">Pays</th>
    <th>Nombre d\'étapes</th>
    <th>Pays</th>
    </tr>';


    for ($i=0;$i<$nb_etape;$i++) {

      echo '
      <tr>
      <td align="center">' . $tab1[$i]["VILLE_D"] . '</td>
      <td align="center">' . $tab1[$i]["NB_ETAPE"] . '</td>
      <td align="center">' . $tab1[$i]["NOM"] . '</td>
      </tr>';
    }
  }
  echo "</center>";

}
  // close connection
  FermerConnexionOCI($conn);

  ?>
