<?php
###################################################
##-= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =- ##
## ----------------------------------------------##
## Project starters: Akakori, TTMMTT and other   ##
## Travian-Core project owner: Songer		     ##
## Project devoloper's: Songer				     ##
## Editors: Dzoki and other...				     ##
## Licence: Travian-Core					     ##
## Release date: 2012.03.17 15:40			     ##
## All right reserverd						     ##
## ENJOY THE TRAVIAN!!						     ##
###################################################

if(isset($_POST)){ 
	if(!isset($_POST['ft'])){
	$_POST = @array_map('mysql_real_escape_string', $_POST);
	$_POST = array_map('htmlspecialchars', $_POST);
	}
}
$_GET = array_map('mysql_real_escape_string', $_GET);
$_GET = array_map('htmlspecialchars', $_GET);
$_COOKIE = array_map('mysql_real_escape_string', $_COOKIE);
$_COOKIE = array_map('htmlspecialchars', $_COOKIE);
?>