<!doctype html>
<html lang="en-US">
	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>AOS - Admin Online Services</title>
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
                      <a class="navbar-brand page-scroll" href="index.php">Admin Online Services</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a class="page-scroll" href="body">Accueil</a></li>
                            <li><a class="page-scroll" href="#services-section">Services</a></li>
                            <li><a class="page-scroll" href="#team-section">L'équipe</a></li>                            
                            <li><a class="page-scroll" href="#prices-section">Offres</a></li>
							
							<!-- Formulaire d'inscription -->			
							<li><a class="page-scroll" href="#modal-1" data-toggle="modal">inscription</a></li>
							<div class="modal" id="modal-1">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3 class="modal-title">Inscription</h3>
										</div>
										<div class="modal-body">
											<form method="POST" id="inscription" action="index.php?p=index">
                                            <div class="row">
                                                <div class="col-md-6">
												        <input type="text" class="form-control" placeholder="Votre nom d'utilisateur" name="nomUtilisateur" onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/ig, '');" />
												        <br />
												        <input type="email" class="form-control" placeholder="Votre mail" name="mail" />
												        <br />
												        <input type="email" class="form-control" placeholder="Votre confirmation de mail" name="confMail" />
												        <br />
												        <input type="password" class="form-control" placeholder="Votre mot de passe" name="motDePasse" />
												        <br />
												        <input type="password" class="form-control" placeholder="Votre confirmation de  mot de passe" name="confMotDePasse" />
												        <br />
                                                </div>
                                            </div>
                                        <div class="modal-footer">
                                                        <button type="button" data-dismiss="modal" class="btn btn-primary">Fermer</button>
                                                        <button type="submit" class="btn btn-success" value="confInscription" name="confInscription">Valider</button>
                                        </div>
											</form>
											<?php
                                                if(isset($messErreurInscription)){
                                                    echo '<div class="messErreurInscription">';
                                                        echo $messErreurInscription;
                                                    echo '</div>';
                                                }
                                                if(isset($messConfInscription)){
                                                    echo '<div class="messConfInscription">';
                                                        echo $messConfInscription;
                                                    echo '</div>';
                                                }
                                            ?>
										</div>
									</div>
								</div>
							</div>
							<!-- Formulaire de connexion -->
							<li><a class="page-scroll" href="#modal-2" data-toggle="modal">connexion</a></li>
							<div class="modal" id="modal-2">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h3 class="modal-title">Connexion</h3>
										</div>
										<div class="modal-body">
											<form method="POST" id="connexion" action="index.php?p=index">
											<div class="row">
                                                <div class="col-md-6">
												    <input type="text" class="form-control" placeholder="Votre nom d'utilisateur" name="nomUtilisateur" />
												    <br />
												    <input type="password" class="form-control" placeholder="Votre mot de passe" name="motDePasse" />
												    <br />
                                                </div>
                                            </div>
                                                <div class="modal-footer">
												    <button type="button" data-dismiss="modal" class="btn btn-primary">Fermer</button>
                                                    <button type="submit" class="btn btn-success" value="confConnexion" name="confConnexion">Se connecter</button>
                                                </div>
											</form>
                                            <?php
                                                if(isset($messErreurConnexion)){
                                                    echo '<div class="messErreurConnexion">';
                                                    echo $messErreurConnexion;
                                                    echo '</div>';
                                                }
                                            ?>
										</div>
									</div>
								</div>
							</div>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                  </div><!-- /.container -->
                </nav>
                <!-- End Navbar -->
				

            </header>
            <!-- ========= END HEADER =========-->
                        
            
        	<!-- Begin text carousel intro section -->
			<section id="text-carousel-intro-section" class="parallax" data-stellar-background-ratio="0.5" style="background-image: url(./vues/img/AOS-psl.png); background-size: 80% auto;";>
			</section>
			<!-- End text carousel intro section -->
              
            <!-- Begin Services -->
            <section id="services-section" class="page text-center">
                <!-- Begin page header-->
                <div class="page-header-wrapper">
                    <div class="container">
                        <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                            <h2>Services</h2>
                            <div class="devider"></div>
                            <p class="subtitle">Hébergement</p>
                        </div>
                    </div>
                </div>
                <!-- End page header-->
            
                <!-- Begin roatet box-2 -->
                <div class="rotate-box-2-wrapper">
                    <div class="container" style="margin-left: 21%">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <a class="rotate-box-2 square-icon text-center wow zoomIn" data-wow-delay="0">
                                    <span class="rotate-box-icon"><i class="fa fa-globe"></i></span>
                                    <div class="rotate-box-info">
                                        <h4>Noms de domaines</h4>
                                        <p style="text-align: justify">Créez votre domaine et hébergez le. Nous vous donnons la possibilité d'importer votre domaine. Vous pourrez y associer tous nos autres services. Rassemblez tous vos services en un afin d'administrer plus aisément, avec un contrôle total sur votre parc informatique.</p>
                                    </div>
                                </a>
                            </div>
            
                            <div class="col-md-3 col-sm-6">
                                <a class="rotate-box-2 square-icon text-center wow zoomIn" data-wow-delay="0.2s">
                                    <span class="rotate-box-icon"><i class="fa fa-envelope-o"></i></span>
                                    <div class="rotate-box-info">
                                        <h4>Boîtes mail</h4>
                                        <p style="text-align: justify">Créez votre boîte mail et hébergez-la chez vous. Vous pouvez également l'héberger dans votre propre domaine préalablement crée. Profitez d'un service fiable et sécurisé, avec un filtre anti-spam.</p>
                                    </div>
                                </a>
                            </div>
            
                            <div class="col-md-3 col-sm-6">
                                <a class="rotate-box-2 square-icon text-center wow zoomIn" data-wow-delay="0.4s">
                                    <span class="rotate-box-icon"><i class="fa fa-file-code-o"></i></span>
                                    <div class="rotate-box-info">
                                        <h4>Sites web</h4>
                                        <p style="text-align: justify">Créez un nom de domaine et faites y correspondre ce que vous voulez : un site web. Sentez-vous libre, vous pouvez l'associer dans AOS ou à votre domaine.</p>
                                    </div>
                                </a>
                            </div>
                        </div> <!-- /.row -->
                    </div> <!-- /.container -->
                    
                    <div class="container">
                        <!-- Cta Button -->
                        <div class="extra-space-l"></div>
                    </div> <!-- /.container -->                       
                </div>
                <!-- End rotate-box-2 -->
            </section>
            <!-- End Services -->
                
            <!-- Begin team-->
            <section id="team-section" class="page">
                <!-- Begin page header-->
                <div class="page-header-wrapper">
                    <div class="container">
                        <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                            <h2>L'équipe</h2>
                            <div class="devider"></div>
                            <p class="subtitle">AOS</p>
                        </div>
                    </div>
                </div>
                <!-- End page header-->
                <div class="container" style="margin-left: 18%">
                    <div class="row">
                        <div class="team-items">
                            <div class="col-md-2">
                                <div class="team-container wow bounceIn" data-wow-delay="0.2s">
                                    <div class="team-item">
                                        <div class="team-triangle">
                                            <div class="content">
                                                <img src="./vues/img/team/rodolphe.jpg" alt="title"/>
                                                <div class="team-hover text-center">
                                                    <i class="fa fa-male"></i>
                                                    <p>Rodolphe Wachter</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="team-container wow bounceIn" data-wow-delay="0.3s">
                                    <div class="team-item">
                                        <div class="team-triangle">
                                            <div class="content">
                                                <img src="./vues/img/team/dimitri.jpg" alt="title"/>
                                                <div class="team-hover text-center">
                                                    <i class="fa fa-male"></i>
                                                    <p>Dimitri Tchapmi</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="team-container wow bounceIn" data-wow-delay="0.4s">
                                    <div class="team-item">
                                        <div class="team-triangle">
                                            <div class="content">
                                                <img src="./vues/img/team/ed.jpg" alt="title"/>
                                                <div class="team-hover text-center">
                                                    <i class="fa fa-male"></i>
                                                    <p>Edouard Ling</p>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>

            </section>
            <!-- End team-->
			
            <!-- Begin prices section -->
			<section id="prices-section" class="page">

                <!-- Begin page header-->
                <div class="page-header-wrapper">
                    <div class="container">
                        <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                            <h2>Offre de services</h2>
                            <div class="devider"></div>
                            <p class="subtitle">Comme vous en rêviez</p>
                        </div>
                    </div>
                </div>
                <!-- End page header-->

				<div class="extra-space-l"></div>

				<!-- Begin prices -->
				<div class="prices">
					<div class="container" style="margin-left: 21%">
						<div class="row">
							
							<div class="price-box col-sm-6 col-md-3 wow flipInY" data-wow-delay="0.3s">
								<div class="panel panel-default">
									<div class="panel-heading text-center">
										<i class="fa fa-globe fa-2x"></i>
										<h3>DNS</h3>
									</div>
									<div class="panel-body text-center">
										<p class="lead"><strong>Gratuit</strong></p>
									</div>
									<ul class="list-group text-center">
										<li class="list-group-item">Gérer ses noms de domaine</li>
										<li class="list-group-item">Importation de votre nom de domaine</li>
										<li class="list-group-item">Création de domaine dans aos.itinet.fr</li>
										<li class="list-group-item">Réserver 2 FQDN dans aos.itinet.fr</li>
									</ul>
									<!--<div class="panel-footer text-center">
										<a class="btn btn-default" href="#">Order Now!</a>
									</div>-->
								</div>										
							</div>

							<div class="price-box col-sm-6 col-md-3 wow flipInY" data-wow-delay="0.5s">
								<div class="panel panel-default">
									<div class="panel-heading text-center">
										<i class="fa fa-envelope-o fa-2x"></i>
										<h3>MAIL</h3>
									</div>
									<div class="panel-body text-center">
										<p class="lead"><strong>Gratuit</strong></p>
									</div>
									<ul class="list-group text-center">
										<li class="list-group-item">Gérer sa boîte mail</li>
										<li class="list-group-item">Créer une boîte mail sur aos.itinet.fr</li>
										<li class="list-group-item">Création de boîte mail dans votre domaine</li>
										<li class="list-group-item">400Mo de stockage</li>
									</ul>
								</div>										
							</div>
							
							<div class="price-box col-sm-6 col-md-3 wow flipInY" data-wow-delay="0.9s">
								<div class="panel panel-default">
									<div class="panel-heading text-center">
										<i class="fa fa-file-code-o fa-2x"></i>
										<h3>WEB</h3>
									</div>
									<div class="panel-body text-center">
										<p class="lead"><strong>Gratuit</strong></p>
									</div>
									<ul class="list-group text-center">
										<li class="list-group-item">Gérer ses sites internet</li>
										<li class="list-group-item">Création de sites web</li>
										<li class="list-group-item">Créer 2 Sites web dans aos.itinet.fr</li>
										<li class="list-group-item">Connexion SFTP</li>
										<li class="list-group-item">Création de bases de données</li>
										<li class="list-group-item">250Mo de stockage</li>
									</ul>
								</div>										
							</div>
							
						</div> <!-- /.row -->
					</div> <!-- /.container -->
				</div>
				<!-- End prices -->
				<div class="extra-space-l"></div>
			</section>
			<!-- End prices section -->
			
            <!-- Begin footer -->
            <footer class="text-off-white">
			
                <div class="footer">
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
        <script src="./vues/js/inscription.js"></script>
        <script src="./vues/js/connexion.js"></script>
        <script src="./vues/js/jquery.validate.min.js"></script>

		<!-- Theme JS -->
		<script src="./vues/js/theme.js"></script>

    </body> 
        
            
</html>
