<?php

session_start();

$_SESSION = [];
session_destroy();

header("location:../main/login-fe.php?pesan=logout");
exit;

?>