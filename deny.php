<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OHG-Abi 20</title>
    <link rel="stylesheet" type="text/css" href="/css/deny/deny.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
        crossorigin="anonymous">
</head>
<body scroll="no">
    <?php
        session_start();
        if(!isset($_SESSION['userid'])) {
            die('Bitte zuerst <a href="login.php">einloggen</a>');
        }
    ?>
    <div id="header">
        <div class="dot shadow" id="test">
            <a href="logout"><i class="fas fa-sign-out-alt"></a></i>
        </div>
    </div>

    <div id="main">   
        <div id="state" class="shadow"><p>Code nicht <br>erkannt</p></div>
        
        <div id="symbol"><i class="fas fa-times-circle"></i></div>
    </div>
</body>
</html>