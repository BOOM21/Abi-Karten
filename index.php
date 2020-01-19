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
    Home
    <a href="login">Login</a>
    <a href="logout">Logout</a>
    <a href="allow">Allow</a>
    <a href="deny">Deny</a>
    
    <?php
    session_start();
    if(!isset($_SESSION['userid']) && isset($_COOKIE['identifier']))
        $_SESSION['userid'] = $user['id'];{
    }
    if(!isset($_SESSION['userid'])) {
        die('Bitte zuerst <a href="login.php">einloggen</a>');
    }
    
    //Abfrage der Nutzer ID vom Login
    $userid = $_SESSION['userid'];
    
    echo "Hallo User: ".$userid;
    ?>
</body>
</html>