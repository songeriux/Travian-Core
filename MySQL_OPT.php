<?php
include("GameEngine/Database.php");
$AllTbl=mysql_query("SHOW TABLES");

while($tbl=mysql_fetch_assoc($AllTbl)){
foreach($tbl as $db){
mysql_query("OPTIMIZE TABLE $db") or die(mysql_error());
}
}