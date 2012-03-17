<?php
function mres($data){
if(function_exists("mysql_real_escape_string")){
$data = mysql_real_escape_string(trim($data));
}else{
$data = mysql_escape_string(trim($data));
}
$data = htmlspecialchars($data);
$data = filter_var($data,FILTER_SANITIZE_STRING);
$data = strip_tags($data);
return $data;
}

# GETai
if(isset($_GET)){
foreach($_GET as $key=>$value)
{
$_GET[$key]=mres($value);
}
}

# POSTAI
if(isset($_POST)){
foreach($_POST as $key=>$value)
{
$_POST[$key]=mres($value);
}
}

# Sesijos
if(isset($_SESSION)){
foreach($_SESSION as $key=>$value){
$_SESSION[$key]=mres($value);
}
}
# Cookie..
if(isset($_COOKIE)){
foreach($_COOKIE as $key=>$value){
$_COOKIE[$key]=mres($value);
}
}

if(isset($_REQUEST)){
foreach($_REQUEST as $key=>$value){
$_REQUEST[$key]=mres($value);
}
}

if(isset($_SERVER)){
foreach($_SERVER as $key=>$value){
$_SERVER[$key]=mres($value);
}
}
?>