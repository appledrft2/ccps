<?php 

$geturl = 'http://'.$_SERVER['HTTP_HOST'].'/ccps/';
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'ccps';

$baseurl = $geturl;
$connection = new mysqli($host,$user,$pass,$db);

?>