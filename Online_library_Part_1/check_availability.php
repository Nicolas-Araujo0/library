<?php 

// On inclue le fichier de configuration et de connexion a la base de donnees
require_once("includes/config.php");
// On recupere dans $_GET l email soumis par l'utilisateur

	// On verifie que l'email est un email valide (fonction php filter_var)
	
		// Si ce n'est pas le cas, on fait un echo qui signale l'erreur
		
		// Si c'est bon
		// On prepare la requete qui recherche la presence de l'email dans la table tblreaders
		// On execute la requete et on stocke le resultat de recherche

		// Si le resultat n'est pas vide. On signale a l'utilisateur que cet email existe deja et on desactive le bouton
		// de soumission du formulaire

		// Sinon on signale a l'utlisateur que l'email est disponible et on active le bouton du formulaire
