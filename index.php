<?php
    session_start();
    if(!isset($_SESSION['userid']) && isset($_COOKIE['identifier'])){
        $_SESSION['userid'] = $user['id'];
    }
    if(!isset($_SESSION['userid'])) {
        header('location:login');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OHG-Abi 20</title>
    <link rel="stylesheet" type="text/css" href="/css/index/index.min.css" />
</head>
<body>
    <?php if(isset($_SESSION['userid'])): ?>
        <a href="logout">Logout</a><br>
    <?php else: ?>
        <a href="login">Login</a><br>
    <?php endif; ?>
    <a href="guests">Guests</a>

</body>
</html>