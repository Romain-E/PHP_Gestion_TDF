<?php
    require_once ("../php_util/connexion.php");
    include_once ("consulter_equipe.html");

	
	$req = "select ville_a as VILLE from tdf_etape
			union
			select ville_d from tdf_etape";
	$cur = PreparerRequeteOCI($conn, $req);
	ExecuterRequeteOCI($cur);
	$nb1 = LireDonneesOCI1($cur, $tabVille);
	echo '<center><table border="8">
			<tr>
			<th>Nom</th>
			<th>Nombre de fois</th>
			</tr>';
	foreach($tabVille as $ville) {
		//print_r($ville);
		$nomVille = preg_replace("/'/","''",$ville['VILLE']);
		$req2 = "select MAX(rownum) as NB from tdf_etape where ville_d = '$nomVille' or ville_a = '$nomVille'";
		$cur = PreparerRequeteOCI($conn, $req2);
		ExecuterRequeteOCI($cur);
		LireDonneesOCI1($cur, $val);
		echo '<tr><td>'.$ville['VILLE']."</td><td>".$val[0]["NB"]."</td></tr>";
	}

?>