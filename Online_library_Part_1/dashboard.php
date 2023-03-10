<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion a la base de donn�es
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
     // Si l'utilisateur est d�connect�
     // L'utilisateur est renvoy� vers la page de login : index.php
     header('location:index.php');
} else {
     $SID = $_SESSION["rdid"];
     // On r�cup�re l'identifiant du lecteur dans le tableau $_SESSION
     $sql = "SELECT count(*) FROM tblissuedbookdetails WHERE ReaderID = :id";
     $sth = $dbh->prepare($sql);
     $sth->bindParam(":id", $SID);
     // On veut savoir combien de livres ce lecteur a emprunte
     // On construit la requete permettant de le savoir a partir de la table tblissuedbookdetails
     $sth->execute();

     $result = $sth->fetch();
     $_SESSION["boo"] = $result[0];
     // On stocke le r�sultat dans une variable

     // On veut savoir combien de livres ce lecteur n'a pas rendu
     // On construit la requete qui permet de compter combien de livres sont associ�s � ce lecteur avec le ReturnStatus � 0 

     // On stocke le r�sultat dans une variable

     $sql = "SELECT count(*) FROM tblissuedbookdetails WHERE ReaderID = :id AND ReturnStatus = 0";
     $sth = $dbh->prepare($sql);
     $sth->bindParam(":id", $SID);
     // On veut savoir combien de livres ce lecteur a emprunte
     // On construit la requete permettant de le savoir a partir de la table tblissuedbookdetails
     $sth->execute();

     $result = $sth->fetch();
     $_SESSION["nonRendu"] = $result[0];

?>

     <!DOCTYPE html>
     <html lang="FR">

     <head>
          <meta charset="utf-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
          <title>Gestion de librairie en ligne | Tableau de bord utilisateur</title>
          <!-- BOOTSTRAP CORE STYLE  -->
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
          <!-- FONT AWESOME STYLE  -->
          <link href="assets/css/font-awesome.css" rel="stylesheet" />
          <!-- CUSTOM STYLE  -->
          <link href="assets/css/style.css" rel="stylesheet" />
     </head>

     <body>
          <!--On inclue ici le menu de navigation includes/header.php-->
          <?php include('includes/header.php'); ?>
          <!-- On affiche le titre de la page : Tableau de bord utilisateur-->
          <h2>Tableau de bord utilisateur : </h2>
          <hr>
          <!-- On affiche la carte des livres emprunt�s par le lecteur-->
          <div class="books-space">
               <a href="">
                    <div class="books">
                         <p>📖</p>
                         <div>
                              <?php echo "<p id='number'> {$_SESSION['boo']}</p>";
                              ?>
                              <p>Livrés emprunté total</p>
                         </div>
                    </div>
               </a>
               <a href="">
                    <div class="books">
                         <p>🌀</p>
                         <div>
                              <?php echo "<p id='number'> {$_SESSION['nonRendu']}</p>";
                              ?>
                              <p>Livres non encore rendus</p>
                         </div>
                    </div>
               </a>
          </div>

          <!-- On affiche la carte des livres non rendus le lecteur-->

          <?php include('includes/footer.php'); ?>
          <style>
               h2{
                    margin-left: 10%;
                    padding: 15px;
               }
               a:hover {
                    text-decoration: none;
               }
               .books {
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    height: fit-content;
                    height: 200px;
                    width: 250px;
                    margin: 30px 0;
               }

               .books p {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0;
               }
               .books p:first-child {
                    margin-top: 20px;
                    font-size: 100px;
               }
               .books div {
                    display: flex;
                    flex-direction: column;
                    padding: 30px 0;
                    row-gap: 10px;
               }
               #number {
                    font-size: 50px;
               }

               .books-space {
                    display: flex;
                    justify-content: space-around;
                    margin: 0 60% 0 10%;
               }

               .books-space a {
                    border: 1px solid black;
                    border-radius: 20px;
               }
          </style>
          <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
     </body>

     </html>
<?php } ?>