<!doctype html>
<html lang="en-US">
	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Aos - web</title>
		<meta name="description" content="Unika - Responsive One Page HTML5 Template">
		<meta name="keywords" content="HTML5, Bootsrtrap, One Page, Responsive, Template, Portfolio" />
		<meta name="author" content="imransdesign.com">

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

		<!-- Skin CSS -->
        <link rel="stylesheet" href="./vues/css/skin/ice-blue.css">

	</head>

    <body data-spy="scroll" data-target="#main-navbar">
        <div class="page-loader"></div>  <!-- Display loading image while page loads -->
    	<div class="body">
        
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
                            <li><a class="page-scroll" href="body">Accueil</a></li>
                            <li><a class="page-scroll" href="index.php?p=dns">DNS</a></li>
                            <li><a class="page-scroll" href="index.php?p=mail">MAIL</a></li>                            
                            <li><a class="page-scroll" href="index.php?p=web">WEB</a></li>
							<li><a class="page-scroll" href="#">Profil</a></li>
							<li><a class="page-scroll" href="index.php?p=deconnexion">Déconnexion</a></li>
							
                            <!--<li><a class="page-scroll" href="#">Connexion</a></li>-->
                        </ul>
                    </div><!-- /.navbar-collapse -->
                  </div><!-- /.container -->
                </nav>
                <!-- End Navbar -->
				

            </header>
            <!-- ========= END HEADER =========-->
			
            <!-- Begin Services -->
            <section id="services-section" class="page text-center" style="padding-top: 10%;">
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
                <!-- End page header-->

				
					<?php
						if (isset($pub) && isset($dev) && $pub[0] == "1" && $dev[0] == "0") {
							echo "<div><h1>Créer votre Site Web</h1>";
							echo "<form method='post' action='../aos/modeles/insert.php'>dev.".$_SESSION['fqdn']." ";
							echo "</select><input type='text' name='test' value='Developpement' readonly>
									<select name='bdd'>
										<option value='add'>Ajouter une base de données</option>
										<option value='noadd'>N'ajouter pas une base de données</option>
									</select>
									<select name='activ'>
										<option value='enabled'>Activer le site web</option>
										<option value='noenabled'>N'activer pas le site web</option>
									</select>
									<input type='submit' value='Créer' name='createdev'>
									</form></br></div>";
						} else {
							if (!isset($pub) || $pub[0] !== "1") {
								echo "<div><h1>Créer votre Site Web</h1>";
								echo "<form method='post' action='../aos/modeles/insert.php'>
											<input type='text' name='fqdn'>.
											<select name='domaine'>";
											$nb = count($domaine);
											for($i=0; $i<$nb; $i++) {
												echo "<option value=".$domaine[$i].">".$domaine[$i]."</option>";
											}
								echo "</select><input type='text' name='test' value='Public' readonly>
										<select name='bdd'>
											<option value='add'>Ajouter une base de données</option>
											<option value='noadd'>N'ajouter pas une base de données</option>
										</select>
										<select name='activ'>
											<option value='enabled'>Activer le site web</option>
											<option value='noenabled'>N'activer pas le site web</option>
										</select>
										<input type='submit' value='Créer' name='createpub'>
									</form></br></div>";
							}
						}
						
						if (!empty($pub) && !empty($dev)) {
							if ($pub[0] == "1" || $dev[0] == "1") {
								echo "<div><h1>Vos Sites Web</h1>";
								if ($pub[0] == "1") {
									echo $_SESSION['nomEnreg']."<br/>";
									if ($pub[1] == "0") {
										echo "<form method='post' action='../aos/modeles/insert.php'><input type='submit' name='pubactiverweb' value='Activer site web'></form>";
									} else {
										echo "<form method='post' action='../aos/modeles/insert.php'><input type='submit' name='pubdesactiverweb' value='Désactiver site web'></form>";
									}
									
									if ($pub[2] == "0") {
										echo "<form method='post' action='../aos/modeles/insert.php'><input type='submit' name='pubactiverbdd' value='Ajouter base de données'></form>";
									} else {
										echo "<form method='post' action='../aos/modeles/insert.php'><input type='submit' name='pubdesactiverbdd' value='Supprimer base données'></form>";
									}
									
									if($dev[0] !== "1")
									echo "<form method='post' action='../aos/modeles/insert.php'><input type='submit' name='pubsupweb' value='Supprimer site web'></form></br>";
								}
								
								if ($dev[0] == "1") {
									echo "dev.".$_SESSION['nomEnreg']."<br/>";
									if ($dev[1] == "0") {
										echo "<form method='post' action='../aos/modeles/insert.php'><input type='submit' name='devactiverweb' value='Activer site web'></form>";
									} else {
										echo "<form method='post' action='../aos/modeles/insert.php'><input type='submit' name='devdesactiverweb' value='Désactiver site web'></form>";
									}
									
									if ($dev[2] == "0") {
										echo "<form method='post' action='../aos/modeles/insert.php'><input type='submit' name='devactiverbdd' value='Ajouter base de données'></form>";
									} else {
										echo "<form method='post' action='../aos/modeles/insert.php'><input type='submit' name='devdesactiverbdd' value='Supprimer base données'></form>";
									}
									echo "<form method='post' action='../aos/modeles/insert.php'><input type='submit' name='devsupweb' value='Supprimer site web'></form></br>";
								}
							}
						}
					?>
				
            </section>
            <!-- End Services -->

            <!-- Begin footer -->
            <footer class="text-off-white">
                <div class="footer" style="margin-top: 4%;">
                    <div class="container text-center wow fadeIn" data-wow-delay="0.4s">
                        <p class="copyright" style="color: e7e7e7">Copyright &copy; 2015 - Designed By <a href="http://www.aos.itinet.fr" class="theme-author">Admin Online Services</a> &amp; Developed by <a href="http://www.aos.itinet.fr" class="theme-author">AOS</a></p>
                    </div>
                </div>

            </footer>
            <!-- End footer -->

            <a href="#" class="scrolltotop"><i class="fa fa-arrow-up"></i></a> <!-- Scroll to top button -->
                                              
        </div><!-- body ends -->
        
        
        
        
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
