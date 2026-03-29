<?php
// end session and redirect them to login

//include the auth file to ensure the session is started
require "parts/auth.php";

//clear sessions
$_SESSION = [];

//unset all session variables in memory
session_unset();

//destroy session on the server
session_destroy();

//redirect the user to the login page when logout
header("Location: login.php");

exit;
?>