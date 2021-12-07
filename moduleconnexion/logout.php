<?php


session_start(); //to ensure you are using same session
$_SESSION = array();
session_destroy(); //destroy the session
header("location: connexion.php" );

exit();
            

?>