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

class multiSort {
	
	function sorte($array)
	{
		for($i = 1; $i < func_num_args(); $i += 3)
		{
			$key = func_get_arg($i);
		   
			$order = true;
			if($i + 1 < func_num_args())
				$order = func_get_arg($i + 1);
		   
			$type = 0;
			if($i + 2 < func_num_args())
				$type = func_get_arg($i + 2);
	
			switch($type)
			{
				case 1: // Case insensitive natural.
					$t = 'strcasenatcmp($a[' . $key . '], $b[' . $key . '])';
					break;
				case 2: // Numeric.
					$t = '$a[' . $key . '] - $b[' . $key . ']';
					break;
				case 3: // Case sensitive string.
					$t = 'strcmp($a[' . $key . '], $b[' . $key . '])';
					break;
				case 4: // Case insensitive string.
					$t = 'strcasecmp($a[' . $key . '], $b[' . $key . '])';
					break;
				default: // Case sensitive natural.
					$t = 'strnatcmp($a[' . $key . '], $b[' . $key . '])';
					break;
			}
			usort($array, create_function('$a, $b', 'return ' . ($order ? '' : '-') . '(' . $t . ');'));
			
		}
		return $array;
	}

};
$multisort = new multiSort;
?>