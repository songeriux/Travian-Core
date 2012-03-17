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
if(count($session->villages) > 1){?>
<table id="vlist" cellpadding="1" cellspacing="1">
   <thead><tr><td colspan="3"><a href="dorf3.php" accesskey="9"><?php echo MULTI_V_HEADER; ?>:</a></td></tr></thead>
	<tbody><?php
		$returnVillageArray = $database->getArrayMemberVillage($session->uid);
		for($i=1;$i<=count($session->villages);++$i){echo'
		<tr>
			<td class="dot '.(($_SESSION['wid'] == $returnVillageArray[$i-1]['wref'] ) ? 'hl':'').'">●</td>
			<td class="link"><a href="?newdid='.$returnVillageArray[$i-1]['wref'].(($id>=19) ? "&id=".$id : "&id=0").'">'.htmlspecialchars($returnVillageArray[$i-1]['name']).'</a></td>
			<td class="aligned_coords"><div class="cox">('.$returnVillageArray[$i-1]['x'].'</div><div class="pi">|</div><div class="coy">'.$returnVillageArray[$i-1]['y'].')</div></td></tr>';
	}?>
	</tbody>
</table>
<?php
}
?>