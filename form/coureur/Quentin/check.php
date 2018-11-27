 <meta charset="UTF-8"> 
 <pre>
 <form method="post" action="">
  Prenom
  <input type="text" name="prenom">
  
  Nom:
  <input type="text" name="nom">
  
  <input type="submit">
</form> 

<?php

if(!empty($_POST['prenom'])) {
	echo 'PRENOM<br>';
	echo $_POST['prenom'].' -> '.prenom($_POST['prenom']);
	echo '<br><br><br>';
}
if(!empty($_POST['nom'])) {
	echo 'NOM<br>';
	echo $_POST['nom'].' -> '.nom($_POST['nom']);
	echo '<br><br><br>';
}



/***********************************************************************************/


function prenom($arg) {
	$vPrenom = $arg;
	
	$vPrenom = mb_strtolower($vPrenom, mb_detect_encoding($vPrenom));
	$vPrenom = enleverAccent($vPrenom);
	$vPrenom = enleverEspace($vPrenom);
	$vPrenom = enleverTiretDebutFin($vPrenom);
	$vPrenom = enleverEspaceAvantApresTiret($vPrenom);
	
	if(empty($vPrenom)){
		return 'Vide';
	}
	if(contientAucunCar($vPrenom)) {
		return "Ne contient aucun caractère";
	}
	if(contientDeuxTiretsALaSuite($vPrenom)) {
		return "Deux tirets à la suite";
	}
	if(contientCarInterdit($vPrenom)) {
		return "Caractere interdit";
	}
	if(contientDeuxApostrophesALaSuite($vPrenom)) {
		return "Deux apostrophes à la suite";
	}
	if(contientTroisApostrophesALaSuite($vPrenom)) {
		return "Trois apostrophes à la suite";
	}
	if(contientPlusDe30Carac($vPrenom)) {
		return "Plus de 30 caractères";
	}
		
		
	$vPrenom = premiereLettreEnMaj($vPrenom);
	return $vPrenom;
}


function nom($arg) {
	$vNom = $arg;
	$vNom = mb_strtoupper($vNom, mb_detect_encoding($vNom));
	$vNom = enleverAccent($vNom);
	$vNom = enleverEspace($vNom);
	$vNom = enleverTiretDebutFin($vNom);
	$vNom = enleverEspaceAvantApresTiret($vNom);
	
	if(empty($vNom)){
		return 'Vide';
	}
	if(contientAucunCar($vNom)) {
		return "Ne contient aucun caractère";
	}
	if(contientTroisTiretsALaSuite($vNom)) {
		return "Trois tirets à la suite";
	}
	if(contientCarInterdit($vNom)) {
		return "Caractere interdit";
	}
	if(contientDeuxApostrophesALaSuite($vNom)) {
		return "Deux apostrophes à la suite";
	}
	if(contientTroisApostrophesALaSuite($vNom)) { // En prenant en compte les espaces
		return "Trois apostrophes à la suite";
	}
	if(contientDeuxFoisDeuxTirets($vNom)) {
		return "Deux fois deux tirets";
	}
	if(contientPlusDe30Carac($vNom)) {
		return "Plus de 30 caractères";
	}
		
	return $vNom;
}


/***********************************************************************************/

function enleverEspace($arg) {
	$arg = preg_replace("/  */"," ", $arg);
	return preg_replace("/^ *| *$/", "", $arg);
}

function enleverEspaceAvantApresTiret($arg) {
	$arg = preg_replace("/ -/", "-", $arg);
	return preg_replace("/- /", "-", $arg);
}

function contientDeuxTiretsALaSuite($arg) {
	return preg_match("/--/",$arg);
}

function contientTroisTiretsALaSuite($arg) {
	return preg_match("/---/",$arg);
}

function contientDeuxApostrophesALaSuite($arg) {
	return preg_match("/''/",$arg);
}

function contientTroisApostrophesALaSuite($arg) {
	return preg_match("/'\s*'\s*'/",$arg);
}

function enleverAccent($arg) {
    $caracSpecTable = array( 'Œ' => 'OE', 'œ' => 'oe', '"' => '\'','á' => 'a', 'Á' => 'A', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'Ä' => 'A', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'É' => 'E', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'Î' => 'I', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'Ö' => 'O', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'Ü' => 'U', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja' );
    return str_replace(array_keys($caracSpecTable), array_values($caracSpecTable), $arg);
}

function contientCarInterdit($arg) {
	$modele = "#[^a-zàâäéèêëïîôöùûüÿçæœ\- ']#i";
	return preg_match("$modele", $arg);
}

function enleverTiretDebutFin($arg) {
	return preg_replace("/^-*|-*$/", "", $arg);
}

function premiereLettreEnMaj($arg) {
	$arg = preg_split('/(?<!^)(?!$)/u', $arg);
	$lettrePrecedente = '-';
	for($i = 0; sizeof($arg) > $i;$i++) {
		if($lettrePrecedente == '-' || $lettrePrecedente == ' ' || $lettrePrecedente == '\'') {
			if(preg_match("#[a-zàâäéèêëïîôöùûüÿçæœ]#i", $arg[$i])){
				$arg[$i] = strtoupperFr($arg[$i]);
				$lettrePrecedente = $arg[$i];
			}
		}
		else {
			$lettrePrecedente = $arg[$i];
		}
	}
	return implode($arg);
}

function strtoupperFr($string) {
   $string = strtoupper($string);
   $string = str_replace(

      array('é', 'è', 'ê', 'ë', 'à', 'â', 'î', 'ï', 'ô', 'ù', 'û', 'ç'),

      array('E', 'E', 'E', 'E', 'A', 'A', 'I', 'I', 'O', 'U', 'U', 'C'),

      $string

   );
   return $string;
}

function contientPlusDe30Carac($arg) {
	return mb_strlen($arg) > 30;
}

function contientAucunCar($arg) {
	$modele = "#[a-zàâäéèêëïîôöùûüÿçæœ]#i";
	return !preg_match("$modele", $arg);
}

function contientDeuxFoisDeuxTirets($arg){
	return preg_match("/--.+--/",$arg);
}

?>

</pre>