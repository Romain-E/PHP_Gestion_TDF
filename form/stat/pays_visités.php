<?php
require_once ("../php_util/connexion.php");
include_once ("pays_visités.html");
require_once ("../php_util/verif_form.php");


/////////////TABLEAU PAYS VISITES//////////////
$req1 = "select sum(nb_etape) as nb_etape, nom from
(
  select COUNT(*) as nb_etape, code_cio_a
  from tdf_etape
  group by code_cio_a
  union
  select COUNT(*), code_cio_d
  from tdf_etape
  group by code_cio_d
  )
  join tdf_nation on code_cio_a=code_cio
  group by code_cio_a, nom
  order by nom";
  $cur1 = PreparerRequeteOCI($conn, $req1);
  ExecuterRequeteOCI($cur1);
  $nb_pays = LireDonneesOCI1($cur1, $tab1);


  if($nb_pays > 0){

    echo '<center><table border="8">
    <tr>
    <th class="text-align:center">Pays</th>
    <th>Nombre d\'étapes</th>
    </tr>';


    for ($i=0;$i<$nb_pays;$i++) {

      echo '
      <tr>
      <td align="center">' . $tab1[$i]["NOM"] . '</td>
      <td align="center">' . $tab1[$i]["NB_ETAPE"] . '</td>
      </tr>';
    }
  }
  echo "</center>";


  // close connection
  FermerConnexionOCI($conn);

  ?>
