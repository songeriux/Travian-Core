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

include("config.php");

switch(DB_TYPE) {
	case 1:
	include("Database/db_MYSQLi.php");
	break;
	//case 2:
	//include("Database/db_MSSQL.php");
	//break;
	default:
	include("Database/db_MYSQL.php");
	break;
}
?>