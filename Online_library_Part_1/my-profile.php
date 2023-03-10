<?php
// On r�cup�re la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');



if (!isset($_SESSION["login"]) && $_SESSION["login"] != "") {
    header("index.php");
    // Si l'utilisateur n'est plus logu�
    // On le redirige vers la page de login
    // Sinon on peut continuer. Apr�s soumission du formulaire de profil
} else {
    if (isset($_POST["name"], $_POST["tel"], $_POST["emailId"]) && ($_POST["name"] != "" && $_POST["tel"] != "" && $_POST["emailId"] != "")) {
        $postedName = $_POST["name"];
        $postedNumber = $_POST["tel"];
        $postedEmail = $_POST["emailId"];

        $sql = "UPDATE tblreaders SET Fullname = :name, MobileNumber = :tel, EmailId = :email WHERE ReaderId = :readerId";
        $sth = $dbh->prepare($sql);
        $sth->bindParam(":name", $postedName);
        $sth->bindParam(":tel", $postedNumber);
        $sth->bindParam(":email", $postedEmail);
        $sth->bindParam(":readerId", $_SESSION["rdid"]);
        $sth->execute();
    }
    // On recupere l'id du lecteur (cle secondaire)
    $id = $_SESSION["rdid"];
    // On recupere le nom complet du lecteur
    $sql = "SELECT * FROM Tblreaders WHERE ReaderId = :id";
    $sth = $dbh->prepare($sql);
    $sth->bindParam(":id", $id);
    $sth->execute();
    // On recupere le numero de portable
    $result = $sth->fetch(PDO::FETCH_OBJ);
    $_SESSION["resultName"] = $result->FullName;
    $_SESSION["resultEmail"] = $result->EmailId;
    $_SESSION["resultNumber"] = $result->MobileNumber;
    $_SESSION["resultRegDate"] = $result->RegDate;
    $_SESSION["resultUpdateDate"] = $result->UpdateDate;
    $_SESSION["resultStatus"] = $result->Status;
}
// On update la table tblreaders avec ces valeurs
// On informe l'utilisateur du resultat de l'operation


// On souhaite voir la fiche de lecteur courant.
// On recupere l'id de session dans $_SESSION

// On prepare la requete permettant d'obtenir 

?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Profil</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />

</head>

<body>
    <!-- On inclue le fichier header.php qui contient le menu de navigation-->
    <?php include('includes/header.php'); ?>
    <!--On affiche le titre de la page : EDITION DU PROFIL-->
    <h2>EDITION DU PROFIL</h2>
    <hr>
    <!--On affiche le formulaire-->
    <form action="my-profile.php" method="POST">
        <!--On affiche l'identifiant - non editable-->
        <span>Identifiant : <?php echo $_SESSION["rdid"]; ?></span>
        <!--On affiche la date d'enregistrement - non editable-->
        <span>Date d'enregistrement : <?php echo $_SESSION["resultRegDate"]; ?></span>
        <!--On affiche la date de derniere mise a jour - non editable-->
        <span>Dernière mise à jour : <?php echo $_SESSION["resultUpdateDate"] = NULL ?  $_SESSION["resultRegDate"] : $_SESSION["resultUpdateDate"]  ?></span>
        <!--On affiche la statut du lecteur - non editable-->
        <span>Statut : <?php echo $_SESSION["resultStatus"] = 1 ?  "Actif" : "Inactif" ?></span>
        <!--On affiche le nom complet - editable-->
        <label for="name">Nom complet :</label>
        <input type="text" name="name" id="name" value="<?php echo $_SESSION["resultName"] ?>">
        <!--On affiche le numero de portable- editable-->
        <label for="tel">Numéro portable :</label>
        <input type="text" name="tel" id="tel" value="<?php echo $_SESSION["resultNumber"] ?>">
        <!--On affiche l'email- editable-->
        <label for="emailId">Email :</label>
        <input type="email" name="emailId" id="emailId" value="<?php echo $_SESSION["resultEmail"] ?>">
        <input type="submit" value="Mettre à jour" id="sub">
    </form>
    <style>
        h2,
        form {
            padding: 20px 30px;
        }

        label,
        span {
            margin-top: 10px;
            font-weight: 600;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form input {
            width: 250px;
        }

        #sub {
            margin-top: 15px;
            margin-left: 50px;
            width: 150px;
            border-radius: 30px;
        }

        #sub:hover {
            cursor: pointer;
            background-color: lightblue;
            transition: 0.3s;
        }
    </style>
    <?php include('includes/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>