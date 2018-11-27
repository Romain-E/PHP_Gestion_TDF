<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"    content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">

    <title>Consulter une clé</title>

    <!-- font -->
    <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">

    <!-- css -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/bootstrap-theme.css" media="screen" >
    <link rel="stylesheet" href="../../css/main_form.css">

</head>

<body class="home" style="background-color:#D9D9D7">

<article class="col-xs-12">
    <header class="page-header">
        <h3 class="page-title" style="text-align:center;">Consulter une clé</h3>
    </header>

    <?php

    $req = $pdo->prepare('INSERT INTO CLE (CLE_NUM, CLE_RANG, CLE_QUANTITE, CLE_REMISE, CLE_LIBELLE, CLE_TYPE)
            VALUES (:cle_num,:cle_rang,:cle_quantite,:cle_remise,:cle_libelle,:cle_type)');
    $req->execute(array(
        'cle_num' => $_POST['cle_num'],
        'cle_rang' => $_POST['cle_ran'],
        'cle_quantite' => $_POST['cle_qua'],
        'cle_remise' => $_POST['cle_rem'],
        'cle_libelle' => $_POST['cle_lib'],
        'cle_type' => $_POST['cle_typ']
    ));
    ?>

    <div class="row">
        <div class="col-xs-1">
            <!-- space -->
        </div>
        <div class="col-xs-10 text-center">
            <h4>Votre clé a bien été créé ! </h4>
        </div>
        <div class="col-xs-1">
            <!-- space -->
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-12 text-center">
            <input class="btn btn-danger" onclick="javascript:window.close()" type="submit" value="Fermer">
        </div>
    </div><br><br>
</article>


<!-- JavaScript placé en bas de page pour améliorer la vitesse de chargement -->
<script src="assets/js/script.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
</body>
</html>
