<!DOCTYPE HTML>
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>[...]</title>
<script type="text/javascript">
function fctClick( obj){
  // récup. de tous les INPUT de la TR passée en paramètre
  var oInput = obj.getElementsByTagName('INPUT');
  // affichage de la value du 1st
  alert( oInput[0].value);
}
</script>
</head>
<body>
<table border>
<?php $val = 2?>

  <tr onclick="fctClick( this)">
    <td><input type="hidden" id="input_1" value=<?php echo $val ?>>Info</td>
    <td>nom</td><td>prenom</td><td>age</td><td>sexe</td>
  </tr>
  <tr onclick="fctClick( this)">
    <td><input type="hidden" id="input_2" value="Info Input 2">Info</td>
    <td>EMERY</td><td>MAMADOU</td><td>19</td><td>FEMELLE</td>
  </tr>
  <tr onclick="fctClick( this)">
    <td><input type="hidden" id="input_2" value="Info Input 3">Info</td>
    <td>DIOUF</td><td>ROMAIN</td><td>18</td><td>FEMEU</td>
  </tr>
</table>
</body>
</html>