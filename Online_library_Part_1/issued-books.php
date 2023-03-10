<?php
// On r�cup�re la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

if (!isset($_SESSION["login"]) && $_SESSION["login"] != "") {
    header("index.php");
} else {
    // $sql = "SELECT users.name, books.title FROM users JOIN books ON users.favouriteBook = books.id";
    // tblbooks BookName ISBNNumber 
    // tblissuedbookdetails ReaderID IssuesDate ReturnDate

    $sql = "SELECT tblissuedbookdetails.ReturnStatus, tblissuedbookdetails.IssuesDate, tblissuedbookdetails.ReturnDate, tblbooks.ISBNNumber, tblbooks.BookName FROM tblissuedbookdetails JOIN tblbooks ON tblissuedbookdetails.BookId = tblbooks.id WHERE tblissuedbookdetails.ReaderID = :rid ORDER BY tblissuedbookdetails.id ";
    $sth = $dbh->prepare($sql);
    $sth->bindParam(":rid", $_SESSION["rdid"]);
    $sth->execute();
    $_SESSION["resultsBook"] = $sth->fetchAll();
    // Si l'utilisateur n'est pas connecte, on le dirige vers la page de login
    // Sinon on peut continuer
    // Si le bouton de suppression a ete clique($_GET['del'] existe)
    // On recupere l'identifiant du livre
    // On supprime le livre en base
    // On redirige l'utilisateur vers issued-book.php
}
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Gestion des livres</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <!--On insere ici le menu de navigation T-->
    <?php include('includes/header.php'); ?>
    <!-- On affiche le titre de la page : LIVRES SORTIS -->
    <h2>LIVRES EMPRUNTES</h2>
    <!-- On affiche la liste des sorties contenus dans $results sous la forme d'un tableau -->
    <div id="grid">
        <span class="head">#</span>
        <span class="head">Titre</span>
        <span class="head">ISBN</span>
        <span class="head">Date de sortie</span>
        <span class="head">Date de retour</span>
        <?php
        $counter = 0;
        foreach($_SESSION["resultsBook"] as $element){
            $counter++;
            echo "<span class='weight'>{$counter}</span>";
            echo "<span class='weight'>{$element["BookName"]}</span>";
            echo "<span class='weight'>{$element["ISBNNumber"]}</span>";
            echo "<span class='weight'>{$element["IssuesDate"]}</span>";
            if ($element["ReturnDate"] == NULL){
                echo "<span style='color:red' class='weight'>Non retourné</span>";
            } else {
                echo "<span class='weight'>{$element["ReturnDate"]}</span>";
            }

        }
        ?>
    </div>
    <!-- Si il n'y a pas de date de retour, on affiche non retourne -->
    <style>
        h2{
            margin: 50px;
        }
        #grid{
            display: grid;
            grid-template-columns:0.5fr repeat(4, 1fr);
            width: 50%;
            border: 1px solid lightgray;
            border-collapse: collapse;
            margin-left: 50px;
        }
        #grid span{
            border-collapse: collapse;
            border: 1px solid lightgray;
            text-align: center;
        }
        .head{
            font-weight: 800;
            font-size: 20px;
        }
        .weight{
            font-weight: 600;
        }
    </style>

    <?php include('includes/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>