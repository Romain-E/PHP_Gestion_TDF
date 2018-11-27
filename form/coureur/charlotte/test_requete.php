<?php
require_once ("../../php_util/connexion.php");


$req2 ="(SELECT eta.VILLE_D as VILLE, v_d.DEPART as DEPART , v_a.ARRIVEE AS ARRIVEE FROM TDF_ETAPE eta
        
        JOIN 
        (
          SELECT VILLE_D as VILLE, count(*) as DEPART FROM TDF_ETAPE
          GROUP BY VILLE_D
        ) v_d ON v_d.VILLE=eta.VILLE_D
        
        JOIN 
        (
          SELECT VILLE_A as VILLE, count(*) as ARRIVEE FROM TDF_ETAPE
          GROUP BY VILLE_A
        ) v_a ON v_a.VILLE=eta.VILLE_D
        
        GROUP BY eta.VILLE_D, v_d.DEPART , v_a.ARRIVEE
        ORDER BY eta.VILLE_D
        )
        UNION
        
        (SELECT VILLE_D as VILLE, count(*) as DEPART, '0' as ARRIVEE FROM TDF_ETAPE
        GROUP BY VILLE_D)
        ";

echo "<br>Requete : ".$req2."<br>";
$cur2 = PreparerRequeteOCI($conn, $req2);
$res2 = ExecuterRequeteOCI($cur2);
$nombre = LireDonneesOCI1($cur2, $tab);

echo "<br> Nombre de lignes : ".$nombre."<br>";
AfficherDonnee2($tab);



?>