<!doctype html>
<html lang="en-US">
	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Aos - web</title>
		<meta name="description" content="Aos - Admin Online Services">
		<meta name="keywords" content="Aos, Admin Online Services" />

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Google Fonts  -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'> <!-- Body font -->
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'> <!-- Navbar font -->

		<!-- Libs and Plugins CSS -->
		<link rel="stylesheet" href="./vues/inc/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="./vues/inc/animations/css/animate.min.css">
		<link rel="stylesheet" href="./vues/inc/font-awesome/css/font-awesome.min.css"> <!-- Font Icons -->
		<link rel="stylesheet" href="./vues/inc/owl-carousel/css/owl.carousel.css">
		<link rel="stylesheet" href="./vues/inc/owl-carousel/css/owl.theme.css">

		<!-- Theme CSS -->
        <link rel="stylesheet" href="./vues/css/reset.css">
		<link rel="stylesheet" href="./vues/css/style.css">
		<link rel="stylesheet" href="./vues/css/mobile.css">
		<link rel="stylesheet" href="./vues/css/web.css">

		<!-- Skin CSS -->
        <link rel="stylesheet" href="./vues/css/skin/ice-blue.css">
		
	</head>

    <body data-spy="scroll" data-target="#main-navbar">
        <!--<div class="page-loader"></div>  <!-- Display loading image while page loads -->
		
    	<div class="body" style="width: 90%; margin-left:auto; margin-right: auto;">
        
            <!--========== BEGIN HEADER ==========-->
            <header id="header" class="header-main">

                <!-- Begin Navbar -->
               <nav id="main-navbar" class="navbar navbar-default navbar-fixed-top" role="navigation"> <!-- Classes: navbar-default, navbar-inverse, navbar-fixed-top, navbar-fixed-bottom, navbar-transparent. Note: If you use non-transparent navbar, set "height: 98px;" to #header -->

                  <div class="container">

                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand page-scroll" href="index.php?p=indexMembre">Admin Online Services</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a class="page-scroll" href="index.php?p=indexMembre">Accueil</a></li>
                            <li><a class="page-scroll" href="index.php?p=dns">DNS</a></li>
                            <li><a class="page-scroll" href="index.php?p=mail">MAIL</a></li>                            
                            <li><a class="page-scroll" href="index.php?p=web">WEB</a></li>
							<li><a class="page-scroll" href="index.php?p=profil">Profil</a></li>
							<li><a class="page-scroll" href="index.php?p=deconnexion">Déconnexion</a></li>
							
                            <!--<li><a class="page-scroll" href="#">Connexion</a></li>-->
                        </ul>
                    </div><!-- /.navbar-collapse -->
                  </div><!-- /.container -->
                </nav><!-- End Navbar -->
            </header>
            <!-- ========= END HEADER =========-->
			
            <!-- Begin Services -->
            <section id="services-section" class="page text-center" style="margin-top: 6%;">
                <!-- Begin page header-->
                <div class="page-header-wrapper">
                    <div class="container">
                        <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                            <h2>Web</h2>
                            <div class="devider"></div>
                            <p class="subtitle">Hébergement</p>
                        </div>
                    </div>
                </div>
			</section>
                <!-- End page header-->
				
				<div class="modal" id="aosPublic">
					<div class="modal-dialog">
						<div class="modal-content" style="margin-top: 20%">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h3 class="modal-title">Création de votre site web</h3>
							</div>
							<div class="modal-body">
								<form method="post" action="index.php?p=web">
									<div class="row">
										<div class="col-md-12">
											<b>Entrez le nom de votre site web</b>
											<br/>
											<br/>
											<input type='text' class='formulaire' placeholder='Nom' name='aosFqdn' onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9.]/ig, '');"/>
											<b>.aos.itinet.fr</b>
											<br/>
											<br/>
											Activer une base de données
											<input type='checkbox' name='aosBdd' value='add'>
											<br/>
											<br/>
											<?php
												/*if (isset($error) && !empty($error)) {
													echo "<b>".$error."</b>";
													echo "<br/><br/><br/>";
												}*/
											?>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" data-toggle="modal" data-dismiss="modal" class="btn btn-primary">Fermer</button>
										<input type="submit" value="Créer" name="createAos" class="btn btn-success">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
				<div class="modal" id="externePublic">
					<div class="modal-dialog">
						<div class="modal-content" style="margin-top: 20%">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h3 class="modal-title">Création de votre site web</h3>
							</div>
							<div class="modal-body">
								<form method="post" action="index.php?p=web">
									<div class="row">
										<div class="col-md-12">
											<b>Entrer le nom de votre site web et Choisissez votre domaine</b>
											<br/>
											<br/>
											<input type="text" name="fqdnDomaine" placeholder="Nom" class="formulaire" onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9.]/ig, '');">
											<select name='domaine' class='formulaire'>";
											<?php
												$nb = count($domaine);
												for($i=0; $i<$nb; $i++) {
													echo "<option value=".$domaine[$i].">".$domaine[$i]."</option>";
												}
											?>
											?>
											</select>
											<br/>
											<br/>
											Activer une base de données
											<input type='checkbox' name='domaineBdd' value='add'>
											<br/>
											<br/>
											<?php
												/*if (isset($errorDomaine) && !empty($errorDomaine)) {
													echo "<b>".$errorDomaine."</b>";
													echo "<br/><br/><br/>";
												}*/
											?>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" data-toggle="modal" data-dismiss="modal" class="btn btn-primary">Fermer</button>
										<input type="submit" value="Créer" name="createDomaine" class="btn btn-success">
										<!--data-toggle="modal" data-dismiss="modal" class="btn btn-success" data-target="#webModal2" name="nameWeb" value="Suivant"/>-->
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
				<div class="modal" id="devAos">
					<div class="modal-dialog">
						<div class="modal-content" style="margin-top: 20%">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h3 class="modal-title">Création de votre site web</h3>
							</div>
							<div class="modal-body">
								<form method="post" action="index.php?p=web">
									<div class="row">
										<div class="col-md-12">
											<b><?php echo "dev.".$fqdnAos;?></b>
											<br/>
											<br/>
											Activer une base de données
											<input type='checkbox' name='aosDevBdd' value='add'>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" data-toggle="modal" data-dismiss="modal" class="btn btn-primary">Fermer</button>
										<input type="submit" value="Créer" name="createDevAos" class="btn btn-success">
										<!--data-toggle="modal" data-dismiss="modal" class="btn btn-success" data-target="#webModal2" name="nameWeb" value="Suivant"/>-->
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
				<?php
					if (isset($fqdnDev)) {
						$backFqdn = explode('.', $fqdnDev, 2);
					}
				?>
				
				<div class="modal" id="aosPublicByDev">
					<div class="modal-dialog">
						<div class="modal-content" style="margin-top: 20%">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h3 class="modal-title">Création de votre site web</h3>
							</div>
							<div class="modal-body">
								<form method="post" action="index.php?p=web">
									<div class="row">
										<div class="col-md-12">
											<b>Entrez le nom de votre site web</b>
											<br/>
											<br/>
											<b><?php echo $backFqdn[1]; ?></b>
											<br/>
											<br/>
											Activer une base de données
											<input type='checkbox' name='aosBdd' value='add'>
											<br/>
											<br/>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" data-toggle="modal" data-dismiss="modal" class="btn btn-primary">Fermer</button>
										<input type="submit" value="Créer" name="publicAos" class="btn btn-success">
										<!--data-toggle="modal" data-dismiss="modal" class="btn btn-success" data-target="#webModal2" name="nameWeb" value="Suivant"/>-->
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
				<div class="page-header-wrapper">
                    <div class="container">
						<div class="page-header text-center wow fadeInDown" data-wow-delay="0.7s">
							<h4>Administration des services web</h4>
						</div>
					</div>
				</div>
				<br/>
				<!--<div class="md-2">
					<input type="button" value="Accéder à PhpMyAdmin" class="btn btn-default" onclick="window.open('http://phpmyadmin.aos.itinet.fr');">
				</div>-->
				<br/>
				<br/>
				<div class="form-group">
					<!--<label for="singlebutton" class="col-md-5 control-label"></label>-->
					<!--<div class="col-md-2" style="margin: 0 6%;">-->
					<div class="col-md-3" style="margin: 0 4%;">
						<input type="button" value="Accéder à PhpMyAdmin" class="btn btn-default" onclick="window.open('http://phpmyadmin.aos.itinet.fr');" style="width: 100%;">
					</div>
					<!--<div class="col-md-2" style="margin: 0 6%;">-->
					<div class="col-md-3" style="margin: 0 4%;">
						<a aria-controls="MonCollapse" aria-expanded="false" data-toggle="collapse" href="#MonCollapse" class="btn btn-info center-block" id="singlebutton">Informations</a>
					</div>
					
					
					<div class="col-md-3" style="margin: 0 4%;">
					<?php
						disk_free_space("C:");
					?>
						<div class="progress" style="margin-top: 1%; margin-bottom: 1%;">
							<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:60%">
								<span class="sr-only">70% Complete</span>
							</div>
							
						</div>
						<?php
								echo disk_total_space("/var/www/".$_SESSION['nomUtilisateur']."")." Mo sur 250 Mo d'espace utilisé";
						?>
					</div>
				</div>
				<br/>
				<br/>
				<br/>
				<br/>
				<section class="collapse" id="MonCollapse">
					<div style="color: red;" class="well">
						<p class="text-center">Pour vous connectez à PhpMyAdmin, utilisez les identifiants de votre compte !</p>
						<p class="text-center">Pour accéder à votre espace de stockage utilisez un client SFTP !</p>
						<p class="text-center">Hôte : sftp://aos.itinet.fr</p>
						<p class="text-center">Login : votre nom de compte</p>
						<p class="text-center">Mdp : votre mot de pass</p>
						<p class="text-center">Port : 3222</p>
					</div>
				</section>
				
				
				<?php
					if (isset($errorDomaine) && !empty($errorDomaine)) {
						echo "<br/>";
						echo "<b><font color='red'>".$errorDomaine."</font></b>";
						echo "<br/><br/><br/>";
					}
					if (isset($error) && !empty($error)) {
						echo "<br/>";
						echo "<b><font color='red'>".$error."</font></b>";
						echo "<br/><br/><br/>";
					}					
					echo "<br/>";
					echo "<br/>";
					echo "<hr>";
					echo "<br/>";
					
					
					echo "<div class='h4' align='left'>";
					echo "Domaine aos.itinet.fr ";
					if ($actifFqdn == 0) {
						echo "<button data-target='#aosPublic' data-toggle='modal' class='btn btn-primary glyphicon glyphicon-plus' type='button' title='Cliquez pour créer un site web dans aos.itinet.fr'></button>";
					}
					echo "</div>";
					echo "<table class='table table-bordered table-condensed table-hover table-striped'><tr>";
					
					if ($publicAvailableAos == "1" || $devAvailableAos == "1") {
						echo "<tr><td><b>Enregistrements<b></td><td><b>Activer/Désactiver<b></td><td><b>Base de données<b></td><td><b>Supprimer<b></td>";
						if($devAvailableAos == "0" || $devAvailableAos == "") {
							echo "<td><b>Développement<b></td>";
						} elseif ($publicAvailableAos == "0" || $publicAvailableAos == "") {
							echo "<td><b>Public<b></td>";
						}
						echo "</tr>";
						if ($publicAvailableAos == "1") {
							if ($publicEnabledAos == "1") {
								echo  "<td><a href='http://".$fqdnAos."' target='http://".$fqdnAos."'>".$fqdnAos."</a></td>";
							} else {
								echo"<td>".$fqdnAos."</td>";
							}
							
							if ($publicEnabledAos == "0" || $publicEnabledAos == "") {
								echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='pubActiverWebAos' value='Activer site web' class='btn btn-success'></form></td>";
							} else {
								echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='pubDesactiverWebAos' value='Désactiver site web' class='btn btn-danger'></form></td>";
							}
							
							if ($publicBddAos == "0" || $publicBddAos == "") {
								echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='pubActiverBddAos' value='Ajouter base de données' class='btn btn-success'></form></td>";
							} else {
								echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='pubDesactiverBddAos' value='Supprimer base données' class='btn btn-danger'></form></td>";
							}
							
							echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='pubSupWebAos' value='Supprimer site web' class='btn btn-danger'></form></td>";
							
							if($devAvailableAos == "0" || $devAvailableAos == "") {
								echo "<td><button class='btn btn-primary' data-toggle='modal' data-target='#devAos'>Créer site Web Développement</button></td>";
							}
							echo "</tr>";
							// echo "</table>";
						}
						
						if ($devAvailableAos == "1") {
							// echo "<table class='table table-bordered table-condensed table-hover table-striped'><tr>";
							if ($devEnabledAos == "1") {
								echo "<td><a href='http://".$fqdnDev."' target='http://".$fqdnDev."'>".$fqdnDev."</a></td>";
							} else {
								echo "<tr><td>".$fqdnDev."</td>";
							}
							
							if ($devEnabledAos == "0" || $devEnabledAos == "") {
								echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='devActiverWebAos' value='Activer site web' class='btn btn-success'></form></td>";
							} else {
								echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='devDesactiverWebAos' value='Désactiver site web' class='btn btn-danger'></form></td>";
							}
							
							if ($devBddAos == "0" || $devBddAos == "") {
								echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='devActiverBddAos' value='Ajouter base de données' class='btn btn-success'></form></td>";
							} else {
								echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='devDesactiverBddAos' value='Supprimer base données' class='btn btn-danger'></form></td>";
							}
							echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='devSupWebAos' value='Supprimer site web' class='btn btn-danger'></form></td>";
							
							if($publicAvailableAos == "0" || $publicAvailableAos == "") {
								echo "<td><button class='btn btn-primary' data-toggle='modal' data-target='#aosPublicByDev'>Créer site Web Public</button></td>";
							}
							echo "</tr>";
						}	
					}
					echo "</table>";
					echo "<br/>";
					echo "<br/>";
					
					
					if (!empty($domaine[0])) {
						echo "<div class='h4' align='left'>";
						echo "Votre domaine ";
						echo "<button data-target='#externePublic' data-toggle='modal' class='btn btn-primary glyphicon glyphicon-plus' type='button' title='Cliquez pour créer un site web dans votre domaine'></button>";
						echo "</div>";
					}
					echo "<table class='table table-bordered table-condensed table-hover table-striped'><tr>";
					if (isset($pubAvailable) && $pubAvailable[0] == "1") {
						$nb = count($pubAvailable);
						if ($nb == 1) {
							$enreg = "Enregistrement";
						} elseif ($nb > 1) {
							$enreg = "Enregistrements";
						}
						/*echo "<button data-target='#aosPublic' data-toggle='modal' class='btn btn-primary glyphicon glyphicon-plus' type='button' title='Cliquez pour créer un site web dans votre domaine'></button>";
						echo "</div>";*/
						
						// echo "<table class='table table-bordered table-condensed table-hover table-striped'><tr>";
						echo "<tr><td><b>".$enreg."<b></td><td><b>Activer/Désactiver<b></td><td><b>Base de données<b></td><td><b>Supprimer<b></td></tr>";
						for ($i = 0; $i < $nb; $i++) {
							// echo "<table class='table table-bordered table-condensed table-hover table-striped'><tr>";
							if ($pubEnabled[$i] == "1") {
								echo "<td><a href='http://".$fqdn[$i]."' target='http://".$fqdn[$i]."'>".$fqdn[$i]."</a></td>";
							} else {
								echo "<td>".$fqdn[$i]."</td>";
							}
							
							if ($pubEnabled[$i] == "0" || $pubEnabled[$i] == "") {
								echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='pubactiverweb".$i."' value='Activer site web' class='btn btn-success'></form></td>";
							} else {
								echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='pubdesactiverweb".$i."' value='Désactiver site web' class='btn btn-danger'></form></td>";
							}
							
							if ($pubBdd[$i] == "0" || $pubBdd[$i] == "") {
								echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='pubactiverbdd".$i."' value='Ajouter base de données' class='btn btn-success'></form></td>";
							} else {
								echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='pubdesactiverbdd".$i."' value='Supprimer base données' class='btn btn-danger'></form></td>";
							}
							
							echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='pubsupweb".$i."' value='Supprimer site web' class='btn btn-danger'></form></td>";
							echo "</tr>";
							// echo "</table>";
						}
					}
					echo "</table>";
					echo "<br/>";
					echo "<br/>";
					
					if (isset($nomEnregWeb)) {
						$nbWeb = count($nomEnregWeb);
						echo "<div class='h4' align='left'>";
						if ($nbWeb == 1) {
							echo "Site web à activer";
							$enreg = "Enregistrement";
						} elseif ($nbWeb > 1) {
							echo "Sites web à activer";
							$enreg = "Enregistrements";
						}
						echo "</div>";
						
						echo "<table class='table table-bordered table-condensed table-hover table-striped'>";
						echo "<tr><td><b>".$enreg."<b></td><td><b>Activer<b></td><td><b>Supprimer<b></td></tr><tr>";
						for ($i = 0; $i < $nbWeb; $i++) {
							echo"<td>".$nomEnregWeb[$i]."</td>";
							echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='activerWeb".$i."' value='Activer site web' class='btn btn-success'></form></td>";
							echo "<td><form method='post' action='index.php?p=web'><input type='submit' name='supWeb".$i."' value='Supprimer site web' class='btn btn-danger'></form></td>";
							echo "</tr>";
						}
						echo "</table>";
						echo "<br/>";
						echo "<br/>";
					}
					
				?>
            <!--</section>
            <!-- End Services -->
		</div><!-- body ends -->

		<!-- Begin footer -->
		<footer class="text-off-white">
			<!--<div class="footer" style="position: relative; bottom: 0; width: 100%;">-->
			<div class="footer" style="margin-top: 40%;">
				<div class="container text-center wow fadeIn" data-wow-delay="0.4s">
					<p class="copyright" style="color: e7e7e7">Copyright &copy; 2015 - Designed By <a href="http://www.aos.itinet.fr" class="theme-author">Admin Online Services</a> &amp; Developed by <a href="http://www.aos.itinet.fr" class="theme-author">AOS</a></p>
				</div>
			</div>
		</footer>
		<!-- End footer -->
		<a href="#" class="scrolltotop"><i class="fa fa-arrow-up"></i></a> <!-- Scroll to top button -->
                                              
        <!--</div><!-- body ends -->
        
				<!-- Plugins JS -->
		<script src="./vues/inc/jquery/jquery-1.11.1.min.js"></script>
		<script src="./vues/inc/bootstrap/js/bootstrap.min.js"></script>
		<script src="./vues/inc/owl-carousel/js/owl.carousel.min.js"></script>
		<script src="./vues/inc/stellar/js/jquery.stellar.min.js"></script>
		<script src="./vues/inc/animations/js/wow.min.js"></script>
        <script src="./vues/inc/waypoints.min.js"></script>
		<script src="./vues/inc/isotope.pkgd.min.js"></script>
		<script src="./vues/inc/classie.js"></script>
		<script src="./vues/inc/jquery.easing.min.js"></script>
		<script src="./vues/inc/jquery.counterup.min.js"></script>
		<script src="./vues/inc/smoothscroll.js"></script>

		<!-- Theme JS -->
		<script src="./vues/js/theme.js"></script>

    </body> 
        
            
</html>
