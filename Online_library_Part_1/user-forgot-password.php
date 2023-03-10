<?php
// On récupère la session courante
session_start();

// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');

if (isset($_POST["emiel"], $_POST["number"], $_POST["pass"], $_POST["verifPass"])) {
     if ($_POST["vercode"] == $_SESSION["vercode"]) {
          try {
               $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $telNum = $_POST["number"];
               $emiel = $_POST["emiel"];
               $pass = md5($_POST["pass"]);
               $sql = "SELECT * FROM tblreaders WHERE EmailID= :email AND MobileNumber = :number";
               $sth = $dbh->prepare($sql);
               $sth->bindParam(":email", $emiel, PDO::PARAM_STR);
               $sth->bindParam(":number", $telNum, PDO::PARAM_STR);
               $sth->execute();
               $result = $sth->fetch(PDO::FETCH_OBJ);
               if (!empty($result)) {
                    $sql = "UPDATE tblreaders SET `Password` = :pass WHERE id = :ided";
                    $sth = $dbh->prepare($sql);
                    $sth->bindParam(":pass", $pass);
                    $sth->bindParam(":ided", $result->id);
                    $sth->execute();
                    if ($sth->rowCount() > 0) {
                         echo "<script>alert(Password changed succefully)</script>";
                    } else {
                         echo "<script>alert(Unexpected error)</script>";
                    }
               }
          } catch (PDOException $e) {
               echo $sql . "<br>" . $e->getMessage();
          }
     }
}
// Après la soumission du formulaire de login ($_POST['change'] existe
// On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
// $_POST["vercode"] et la valeur initialisee $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas)

// Si le code est incorrect on informe l'utilisateur par une fenetre pop_up

// Sinon on continue
// on recupere l'email et le numero de portable saisi par l'utilisateur
// et le nouveau mot de passe que l'on encode (fonction password_hash)

// On cherche en base le lecteur avec cet email et ce numero de tel dans la table tblreaders

// Si le resultat de recherche n'est pas vide
// On met a jour la table tblreaders avec le nouveau mot de passe
// On informa l'utilisateur par une fenetre popup de la reussite ou de l'echec de l'operation
?>

<!DOCTYPE html>
<html lang="FR">

<head>
     <meta charset="utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

     <title>Gestion de bibliotheque en ligne | Recuperation de mot de passe </title>
     <!-- BOOTSTRAP CORE STYLE  -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
     <!-- FONT AWESOME STYLE  -->
     <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- CUSTOM STYLE  -->
     <link href="assets/css/style.css" rel="stylesheet" />

     <script type="text/javascript">
          // On cree une fonction nommee valid() qui verifie que les deux mots de passe saisis par l'utilisateur sont identiques.
          function valid() {
               let password = document.querySelector("#pass").value;
               let copyPassword = document.querySelector("#verifPass").value;
               if (password == copyPassword && (password != "" && copyPassword != "")) {
                    return true;
               } else {
                    return false;
               }
          }
     </script>

</head>

<body>
     <!--On inclue ici le menu de navigation includes/header.php-->
     <?php include('includes/header.php'); ?>
     <!-- On insere le titre de la page (RECUPERATION MOT DE PASSE -->

     <!--On insere le formulaire de recuperation-->
     <!--L'appel de la fonction valid() se fait dans la balise <form> au moyen de la propri�t� onSubmit="return valid();"-->
     <h2>Récupération du mot de passe</h2>
     <form action="user-forgot-password.php" method="POST" onSubmit="return valid()">
          <div class="formulaire">
               <label for="emiel">Email</label>
               <input type="email" name="emiel" id="emiel">
               <span id="mail-verify"></span>
          </div>
          <div class="formulaire">
               <label for="number">Portable :</label>
               <input type="number" name="number" id="number">
          </div>
          <div class="formulaire">
               <label for="pass">Mot de pass</label>
               <input type="password" name="pass" id="pass">
          </div>
          <div class="formulaire">
               <label for="verifPass">Confirmez le mot de passe</label>
               <input type="password" name="verifPass" id="verifPass">
          </div>
          <div id="vercode">
               <label for="vercode">Code de vérification</label>
               <input type="number" name="vercode" id="vercode">
               <img src="captcha.php">
          </div>
          <input type="submit" value="Validate" id="sub">
     </form>

     <style>
          h2 {
               margin-left: 38%;
          }

          form {
               width: 100%;
               margin: 0 40%;
          }

          .formulaire {
               display: flex;
               flex-direction: column;
          }

          .formulaire input {
               width: 350px;
          }

          #vercode {
               margin-top: 10px;
          }

          #vercode input {
               width: 130px;
               height: 25px;
          }

          #sub {
               margin-bottom: 10px;
               background-color: red;
               color: whitesmoke;
               border-radius: 5px;
               border: none;
               width: 100px;
               height: 45px;
          }

          #sub:hover {
               border: 2px solid black;
               cursor: pointer;
          }
     </style>
     <?php include('includes/footer.php'); ?>
     <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>