<?php
require_once("../../../pdo.php");
include("../../../pdo_oracle.php");
?>

<?php
$erreur = true;
if ( !empty($_POST ))
{
	$erreur = false;
	if (!empty($_POST['cle_num']) && $_POST['cle_num'] != "")
    $cle_num = $_POST['cle_num'];
	else
	{
		echo "cle_num est vide <br />";
		$erreur = true;
	}
	if (!empty($_POST['cle_ran']) && $_POST['cle_ran'] != "")
		$cle_rang = $_POST['cle_ran'] ;
	else
	{
		echo "cle_rang est vide <br />";
		$erreur = true;
	}
	if (!empty($_POST['cle_qua']) && $_POST['cle_qua'] != "")
		$cle_quantite = $_POST['cle_qua'] ;
	else
	{
		echo "cle_quantite est vide <br />";
		$erreur = true;
	}
	if (!empty($_POST['cle_rem']) && $_POST['cle_rem'] != "")
		$cle_remise = $_POST['cle_rem'] ;
	else
	{
		echo "cle_remise est vide <br />";
		$erreur = true;
	}
	if (!empty($_POST['cle_lib']) && $_POST['cle_lib'] != "")
		$cle_libelle = $_POST['cle_lib'] ;
	else
	{
		echo "cle_lib est vide <br />";
		$erreur = true;
	}
  if (!empty($_POST['cle_typ']) && $_POST['cle_typ'] != "")
		$cle_typ = $_POST['cle_typ'] ;
	else
	{
		echo "cle_typ est vide <br />";
		$erreur = true;
	}


	if ($erreur == false)
	{
    include("cle_verif.php");
	}
}
if ($erreur == true)
{
  include ("verif_form.php");
	include ("cle.html")	 ;
}
?>
