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

class Mailer {
	
	function sendActivate($email,$username,$pass,$act) {
		
		$subject = "Welcome to ".SERVER_NAME;
		
		$message = "Hello ".$username."

Thank you for your registration.

----------------------------
Name: ".$username."
Password: ".$pass."
Activation code: ".$act."
----------------------------

Click the following link in order to activate your account:
".SERVER."activate.php?code=".$act."

Greetings,
Travian Core";
				
		$headers = "From: Mailer@".SERVER_NAME."\n";
		//$headers .= 'MIME-Version: 1.0' . "\r\n";
		//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		mail($email, $subject, $message, $headers);
	}
	
};
$mailer = new Mailer;
?>