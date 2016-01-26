<!doctype html>
<html lang="en-US">
	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Aos - dns</title>
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
		<!--<link rel="stylesheet" href="css/skin/cool-gray.css">-->
        <link rel="stylesheet" href="./vues/css/skin/ice-blue.css">
        <!-- <link rel="stylesheet" href="css/skin/summer-orange.css"> -->
        <!-- <link rel="stylesheet" href="css/skin/fresh-lime.css"> -->
        <!-- <link rel="stylesheet" href="css/skin/night-purple.css"> -->

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

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
                            <h2>DNS</h2>
                            <div class="devider"></div>
                            <p class="subtitle">Ajouter votre domaine</p>
                        </div>
                    </div>
                </div>
            <div style="margin-left: 250px";>
                <form method="POST" action="index.php?p=dns">
    				<div class="form-group col-md-3 center">
                        <input type="text" class="form-control" placeholder="Votre domaine" name="domaineNs">
                    </div>
                    <div class="form-group col-md-3 center">
						  <select class="form-control" name="selectionTld">
						    <option>.fr</option>
						    <option>.com</option>
						    <option>.org</option>
						    <option>.net</option>
						  </select>
					</div>
                    <div class="form-group col-md-2 center">
                        <input type="submit" class="btn btn-success" value="Ajouter votre domaine" name="ajoutDomaine">
                    </div>
    			</form>
    			</br></br></br></br>
			</div>	
            <?php
                if(isset($messErreurDomaine)){
                    echo '<div class="messErreurDomaine">';
                    echo $messErreurDomaine;
                    echo '</div>';
                }
                if(isset($messConfirmDomaine)){
                    echo '<div class="messConfirmDomaine">';
                    echo $messConfirmDomaine;
                    echo '</div>';
                }
            ?>
            </br></br>
            <?php
                if($tabDomaine){
                    echo '<table class="table table-bordered table-hover table-striped">';
                    echo '<thead>'; 
                        echo '<tr>'; 
                            echo '<td>Domaine</td>'; 
                            echo '<td>Suppression</td>';
                        echo '</tr>'; 
                    echo '</thead>';
                    foreach($tabDomaine as $valeur){
                        echo '<form action="index.php?p=dns" method="POST">';
                            echo '<tbody>'; 
                                echo '<tr>';
                                    echo '<td>';
                                        echo $valeur;
                                        echo '<input type="hidden" name="valeurDns" value="'.$valeur.'">';
                                    echo '</td>';
                                    echo '<td>';
                                        echo '<input type="submit" name="supprimerExterne" class="btn btn-danger" value="Supprimer">';
                                    echo '</td>';
                                echo '<tr>';
                            echo '<tbody>';
                        echo '</form>';                           
                    }
                    echo '</table>';  
                }    
            ?>	
            </section>
                <!-- Begin page header-->
                <div class="page-header-wrapper">
                    <div class="container">
                        <div class="page-header text-center wow fadeInDown" data-wow-delay="0.7s">
                            <h2>DNS</h2>
                            <div class="devider"></div>
                            <p class="subtitle">Ajouter des enregistrements</p>
                        </div>
                    </div>
                </div>
             <div style="margin-left: auto; margin-right: auto;";>
                <form method="POST" action="index.php?p=dns">
    				<div class="form-group col-md-3 center">
                        <input type="text" class="form-control" placeholder="Nom de l'enregistrement" name="nomEnregistrement">
                    </div>
                    <?php
                        $nb = count($tabDomaine);
                        echo '<div class="form-group col-md-3 center">';
                        echo '<select name="domaine" class="form-control">';
                        for($i=0; $i<$nb; $i++) {
                            echo '<option>'.$tabDomaine[$i].'</option>';
                        }
                        echo '</select>';
                        echo '</div>';
                        ?>
                    <div class="form-group col-md-3 center">
						  <select class="form-control" id="selectionTld" name="type">
						    <option>mx</option>
						    <option>fqdn</option>
						  </select>
					</div>
					<div class="form-group col-md-3 center">
                        <input type="text" class="form-control" placeholder="Adresse Ip" name="ipEnregistrement">
                    </div>
                    <div style= "text-align: justify; color: red; margin-left: 970px;">
                    <p>Attention : Si vous ne remplissez pas ce champs,</p>                    
                    <p>il sera automatiquement rempli par l'adresse ip de notre serveur !</p>
                    </div>
                        <?php
                            if(isset($messErreurEnregistrement)){
                                echo '<div class="messErreurEnregistrement">';
                                echo $messErreurEnregistrement;
                                echo '</div>';
                            }
                            if(isset($messConfirmEnregistrement)){
                                echo '<div class="messConfirmEnregistrement">';
                                echo $messConfirmEnregistrement;
                                echo '</div>';
                            }
                        ?>
                    </br></br>
                    <div style="margin-left: 530px;";>
                        <input type="submit" class="btn btn-success" value="Ajouter votre enregistrement" name="ajoutEnregistrement">
                    </div>
                    </br>
    			</form>
			</div>
            
                </br></br>
                <?php
                    if($tabEnregistrement){
                        $nbDomaineEnreg = 0;
                        $nbType = 0;
                        $nbAdresseIp = 0;
                        echo '<table class="table table-bordered table-condensed table-hover table-striped">';
                            echo '<thead>'; 
                                echo '<tr>'; 
                                    echo '<td>Nom enregistrement</td>'; 
                                    echo '<td>Domaine</td>';
                                    echo '<td>Type</td>';
                                    echo '<td>Adresse ip</td>';
                                    echo '<td>Suppression</td>';
                                echo '</tr>'; 
                            echo '</thead>';
                        foreach($tabEnregistrement as $valeurEnregistrement){    
                                echo '<form action="index.php?p=dns" method="POST">';
                                        echo '<tbody>'; 
                                            echo '<tr>';
                                                echo '<td>';
                                                    echo $valeurEnregistrement;
                                                    echo '<input type="hidden" name="valeurEnregistrement" value="'.$valeurEnregistrement.'">';
                                                echo '</td>';
                                                echo '<td>';
                                                    echo $tabDomaineEnreg[$nbDomaineEnreg];
                                                echo '</td>';
                                                echo '<td>';
                                                    echo $tabType[$nbType];
                                                echo '</td>';
                                                echo '<td>';
                                                    echo $tabAdresseIp[$nbAdresseIp];
                                                echo '</td>';
                                                echo '<td>';
                                                    echo '<input type="submit" name="supprimerEnregistrement" class="btn btn-danger" value="Supprimer">';   
                                                echo '</td>';
                                            echo '</tr>';         
                                        echo '</tbody>';
                                echo '</form>';
                        $nbDomaineEnreg = $nbDomaineEnreg + 1;
                        $nbType = $nbType + 1;
                        $nbAdresseIp = $nbAdresseIp +1;      
                        }
                        echo '</table>';
                    }
                ?>  	   
            <!-- End Services -->

            <!-- Begin footer -->
            <footer class="text-off-white">
                <div class="footer" style="margin-top: 12.1%;">
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
