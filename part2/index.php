<?php

// Import System Classes
require_once('./config/database.php');
require_once('./classes/System.php');
require_once('./classes/EML_Parsing.php');
require_once('./components/auth_user.php');

if($user){
    $link = './dashboard.php';
    header( "Location: $link" ) ;
}else{
    $link = './login.php';
    header( "Location: $link" ) ;
}