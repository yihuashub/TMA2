<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

function get_user($db,$email)
{

    $sql = "SELECT * FROM `users` WHERE `email` = '$email' ";
    $result = $db->query($sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    else{
        return false;
    }
}
/// end of functions
///
/// start global  variable
$db = new Database();
$system = new System($db);
$parsing = new EML_Parsing($db);
$user = null;
$login = '';

if (!empty($_COOKIE['login'])) {
    $login = $_COOKIE['login'];
}
if ($login) {
    list($c_email, $cookie_hash) = explode(',', $_COOKIE['login']);
    $result = get_user($db,$c_email);

    if($result){
        if (strcmp($result['password'],$cookie_hash) === 0) {
            $user = $result;
        }
    }
}
