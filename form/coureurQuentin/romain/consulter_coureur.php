<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"    content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">

    <title>Consulter un coureur</title>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">

        /*function suppr(){
            alert("test");
            $.ajax({
                alert("test2");
            url : "suppr_coureur.php", // ça c'est la page vers laquelle ta requete ajax seras envoyé
                data: {  // ici c'est que j'envoie sur la page
                num : $('#num_cou').val() // donc j'envoie 'num' qui correspond à ce qui est dans mon input 'num_cou'
            },

            type: 'POST', // je l'envoie en POST

                success: function (data) {   // si ça à marché
                $('#result').html(data); // je lui dit de rafraichir ma div 'result' avec les 'data' de la page suppr_coureur.php
            }
        });
        }*/

        function suppr(actual_num_cour){
            xhttp= new XMLHttpRequest();
            xhttp.open("POST", "suppr_coureur.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send(actual_num_cour);
            //alert(actual_num_cour);
        }


    </script>

</head>

<body>

<?php
require_once ("../../php_util/connexion.php");

$erreur = false;

if(isset($_REQUEST["term"])){

    if (!empty($_POST['tst'])){
        echo $_POST['tst'];
    }

    // Prepare un select
    $req = "SELECT cou.N_COUREUR, cou.NOM as NOM_COUREUR, PRENOM, ANNEE_NAISSANCE, ANNEE_PREM, pays.NOM as NOM_PAYS
			FROM TDF_COUREUR cou
			JOIN TDF_APP_NATION nat ON nat.N_COUREUR=cou.N_COUREUR
			JOIN TDF_NATION pays ON pays.CODE_CIO=nat.CODE_CIO
			WHERE cou.NOM LIKE upper(:search) ORDER BY cou.NOM";

    if($cur = PreparerRequeteOCI($conn, $req)){

        // Bind variables to the prepared statement as parameters
        ajouterParamOCI($cur, ":search", $param_term, 200);

        // Set parameters
        $param_term = $_REQUEST["term"] . '%';

        // Tentative d'execution
        if(ExecuterRequeteOCI($cur)){
            $nb_ligne = LireDonneesOCI1($cur, $tab);

            // Check number of rows in the result set
            if($nb_ligne > 0){
                // Fetch result rows as an associative array
                /*while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<p>" . $row["name"] . "</p>";
                }*/

                echo '<form action="suppr_coureur.php" method="post">
						<table border="1" id="monTableau">
							<tr>
								<th>Numéro</th>
								<th>Nom</th>
								<th>Prenom</th>
								<th>Annee de naissance</th>
								<th>Année de première participation</th>
								<th>Nationalité</th>
								<th>SUPPRIMER</th>
								<th>MODIFIER</th>
							</tr>';

                for ($i=0;$i<$nb_ligne;$i++) {
                    echo '
							<tr>
								<td align="center">'.$tab[$i]["N_COUREUR"].'</td>
								<td align="center">'.$tab[$i]["NOM_COUREUR"].'</td>
								<td align="center">'.$tab[$i]["PRENOM"].'</td>
								<td align="center">'.$tab[$i]["ANNEE_NAISSANCE"].'</td>
								<td align="center">'.$tab[$i]["ANNEE_PREM"].'</td>
								<td align="center">'.$tab[$i]["NOM_PAYS"].'</td>
								<input type="hidden" name="cou_num'.$i.'" value="'.$tab[$i]["N_COUREUR"].'">
								<td align="center"><input type="submit" name="suppr" value="-"></td>
								<td align="center"><input type="submit" name="modif" value="~"></td>
							</tr>';
                }
                echo '</table>
					</form>';
            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            //echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }

}

//require("suppr_coureur.php");
// close connection
FermerConnexionOCI($conn);

?>

</body>
</html>
