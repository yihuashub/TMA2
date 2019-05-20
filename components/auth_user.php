<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

function get_hash($email)
{
    $db = new Database();

    $sql = "SELECT * FROM `users` WHERE `email` = '$email' ";
    $result = $db->query($sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    else{
        return false;
    }
}

$user = null;

if ($_COOKIE['login']) {
    $db = new Database();
    list($c_email, $cookie_hash) = split(',', $_COOKIE['login']);
    $result = get_hash($c_email);

    if (strcmp($result['password'],$cookie_hash) === 0) {
        $user = $result;
    }
}
