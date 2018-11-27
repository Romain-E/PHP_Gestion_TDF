<?php
require_once("fonc_oracle.php");
include_once ("util_chap11.php");
$login = 'ETU2_58';
$mdp = 'nutella4ever';
$instance = 'spartacus.iutc3.unicaen.fr:1521/info.iutc3.unicaen.fr';
// ce code ne doit pas être dans le <select> … </select>
try{
    $conn = OuvrirConnexionOCI($login, $mdp,$instance);
}catch(Exception $e){
    echo "Connexion échouée !";
}?>
