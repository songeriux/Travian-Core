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

function addSub($subName, $sub)
{
	$GLOBALS['subs']["{".$subName."}"] = $sub;
}

function template($filepath, $subs)
{
	global $s;
	if(file_exists($filepath))
	{
		$text = file_get_contents($filepath);
	} else {
		print "File '$filepath' not found";
		return false;
	}
	
	foreach($subs as $sub => $repl)
	{
		$text = str_replace($sub, $repl, $text);
	}
	
	ob_start();
		eval("?>".$text);
		$text = ob_get_contents();
	ob_end_clean();
	return $text;
}

?>