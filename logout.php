<?php
session_start();
unset($_SESSION['userid']);
setcookie("identifier","",time()-(3600*24*365)); 
session_destroy();

sleep(2);
header('location:http://ohg-abi.de');
?>