<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <script type="text/javascript" src="script.js"></script>

  <title>Créer un coureur</title>
</head>

<body style="background-color:#d8d4d4;">
  <?php include('/users/21700957/www-dev/etudiant/TravauxSecretDEtat/Projet/form/inc/navbar.php'); ?>


  <header><br>
    <h3 class="page-title" style="text-align:center;">Création d'un sponsor</h3><br>
	<h4 class="page-title" style="text-align:center;">Choix de création</h4>
  </header><br>

  <center>
  <form action="creer_sponsor.php" method="post" enctype="application/x-www-form-urlencoded">
	<input class="button" type="submit" value="Créer ce sponsor avec une équipe déjà existante" name="EN">
  </form>
  
  <form action="../equipe/creer_equipe.php" method="post" enctype="application/x-www-form-urlencoded">
    <input class="button" type="submit" value="Créer ce sponsor avec une nouvelle équipe" name="EN">
  </form>
  </center>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>