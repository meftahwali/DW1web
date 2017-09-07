<?php
include 'connect.php';
//
$tp1='includes/tamplates/'; 
$lang='includes/languages/';
$func='includes/functions/';
$css='layout/css/';
$js='layout/js/';


// Include The files
include $func.'function.php';
include $lang.'english.php';
include $tp1.'header.php';

if (!isset($noNavbar)) { include $tp1.'navbar.php';};
