<?php

// On inclue le fichier de configuration et de connexion a la base de donnees
require_once("includes/config.php");
// On recupere dans $_GET l email soumis par l'utilisateur

$email = $_GET["email"];
$check = filter_var($email, FILTER_VALIDATE_EMAIL);
if ($check) {
	$sql = "SELECT EmailId FROM tblreaders WHERE EmailId = :email";
	$sth = $dbh->prepare($sql);
	$sth->bindParam(":email", $email, PDO::PARAM_STR);
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_OBJ);
	if (!empty($result)) {
		echo json_encode("Mail is already used");
	} else {
		echo json_encode("You can use this mail adress");
	}
}else {
	echo json_encode("Mail not valide");
}

	// On verifie que l'email est un email valide (fonction php filter_var)
	
		// Si ce n'est pas le cas, on fait un echo qui signale l'erreur
		
		// Si c'est bon
		// On prepare la requete qui recherche la presence de l'email dans la table tblreaders
		// On execute la requete et on stocke le resultat de recherche

		// Si le resultat n'est pas vide. On signale a l'utilisateur que cet email existe deja et on desactive le bouton
		// de soumission du formulaire

		// Sinon on signale a l'utlisateur que l'email est disponible et on active le bouton du formulaire

?>