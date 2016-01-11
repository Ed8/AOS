<?php

if(!empty($_GET['p']) AND is_file('controleurs/'.$_GET['p'].'.php')){

	include('controleurs/'.$_GET['p'].'.php');

} else {
	
	include('controleurs/index.php');

}


?>