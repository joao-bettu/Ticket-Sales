<?php 

session_start();
session_unset();
session_destroy();

header("Location: /../../public/login.html");
exit();
?>