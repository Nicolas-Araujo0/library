<?php
// On récupère la session courante
session_start();

// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');

if ((TRUE === isset($_POST[""])) && isset($_POST[""]) != "") {
    // Après la soumission du formulaire de compte (plus bas dans ce fichier)
    // On vérifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
    // $_POST["vercode"] et la valeur initialisée $_SESSION["vercode"] lors de l'appel à captcha.php (voir plus bas)
    try {
        if ($_SESSION["vercode"] == $_POST["vercode"]) {
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //On lit le contenu du fichier readerid.txt au moyen de la fonction 'file'. Ce fichier contient le dernier identifiant lecteur cree.
            // On incrémente de 1 la valeur lue
            // On ouvre le fichier readerid.txt en écriture
            // On écrit dans ce fichier la nouvelle valeur
            $file = file("readerid.txt")[0];
            $file++;
            file_put_contents("readerid.txt", $file);
            // On referme le fichier
            $lectID = $_POST["lecteur"];
            // On récupère le nom saisi par le lecteur
            $telNum = $_POST["number"];
            // On récupère le numéro de portable
            $emiel = $_POST["emailId"];
            // On récupère l'email
            $pass = $_POST["password"];
            // On récupère le mot de passe
            $status = 1;
            // On fixe le statut du lecteur à 1 par défaut (actif)
            $sql = "INSERT INTO (ReaderId, FullName, EmailID, MobileNumber, Password, Status) VALUES (:readerId, :name, :email, :number, :pass)";
            $sth = $dbh->prepare($sql);
            $sth->bindParam(":readerId", $file, PDO::PARAM_STR);
            $sth->bindParam(":name", $lectID, PDO::PARAM_STR);
            $sth->bindParam(":email", $emiel, PDO::PARAM_STR);
            $sth->bindParam(":telNum", $emiel, PDO::PARAM_STR);
            $sth->bindParam(":pass", $pass, PDO::PARAM_STR);
            // On prépare la requete d'insertion en base de données de toutes ces valeurs dans la table tblreaders
            $sth->execute();
            // On éxecute la requete
            $lastID = $dbh->lastInsertId();
            echo "New users registered successfully. Your ID is : " . $lastID;
        }
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    // On récupère le dernier id inséré en bd (fonction lastInsertId)

    // Si ce dernier id existe, on affiche dans une pop-up que l'opération s'est bien déroulée, et on affiche l'identifiant lecteur (valeur de $hit[0])
    // Sinon on affiche qu'il y a eu un problème
}
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>Gestion de bibliotheque en ligne | Signup</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <!-- link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' / -->
    <script type="text/javascript">
        function valid(){
            let password = document.querySelector(".password");
            let copyPassword = document.querySelector(".passwordCopy");
            if (password == copyPassword){
                return TRUE;
            } else {
                return FALSE;
            }
        }

        // On cree une fonction valid() sans paramètre qui renvoie 
        // TRUE si les mots de passe saisis dans le formulaire sont identiques
        // FALSE sinon
        function  checkAvailability(email){

            
            

        }
        // On cree une fonction avec l'email passé en paramêtre et qui vérifie la disponibilité de l'email
        // Cette fonction effectue un appel AJAX vers check_availability.php
    </script>
</head>

<body>
    <!-- On inclue le fichier header.php qui contient le menu de navigation-->
    <?php include('includes/header.php'); ?>
    <!--On affiche le titre de la page : CREER UN COMPTE-->
    <!--On affiche le formulaire de creation de compte-->
    <!--A la suite de la zone de saisie du captcha, on insère l'image créée par captcha.php : <img src="captcha.php">  -->
    <!-- On appelle la fonction valid() dans la balise <form> onSubmit="return valid(); -->
    <!-- On appelle la fonction checkAvailability() dans la balise <input> de l'email onBlur="checkAvailability(this.value)" -->



    <?php include('includes/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>