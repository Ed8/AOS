<?php
session_start();
if(!isset($_SESSION['idUtilisateur'])){
    header('Location: index.php');
}
include(dirname(__FILE__).'/../vues/vIndexMembre.php');
?>