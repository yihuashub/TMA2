<?php
$secret_word = 'if i ate spinach';
if (pc_validate($_REQUEST['username'], $_REQUEST['password'])) {
    setcookie('login', $_REQUEST['username'] . ',' . md5($_REQUEST['username'] . $secret_word));
}

function pc_validate($user, $pass)
{ /* replace with appropriate username and password checking, such as checking a database */
    $users = array('david' => 'fadj&32', 'adam' => '8HEj838');
    if (isset($users[$user]) && ($users[$user] == $pass)) {
        return true;
    } else {
        return false;
    }
}