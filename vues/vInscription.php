<html>
	<head>
			<title>Inscription</title>
			<meta charset="utf-8">
	</head>
	<body>
		<div align="center">
			<h2>Inscription</h2>
			<br /><br />
			<form method="POST" action="index.php?p=inscription">
				<label>Nom d'utilisateur :</label>
				<input type="text" placeholder="votre nom d'utilisateur" name="nomUtilisateur" />
				<br />
				<label>Adresse mail :</label>
				<input type="email" placeholder="votre mail" name="mail" />
				<br />
				<label>Confirmation adresse mail :</label>
				<input type="email" placeholder="votre confirmation de mail" name="confMail" />
				<br />
				<label>Mot de passe :</label>
				<input type="password" placeholder="votre mot de passe" name="motDePasse" />
				<br />
				<label>Confirmation du mot de passe :</label>
				<input type="password" placeholder="votre confirmation de  mot de passe" name="confMotDePasse" />
				<br />
				<button type="submit" value="confInscription" name="confInscription">Valider votre inscription</button>
			</form>
			<?php
			if(isset($erreur)){
				echo $erreur;
			}
			?>
		</div>
	</body>
</html>