<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OHG-Abi 20</title>
    <link rel="stylesheet" type="text/css" href="/css/allow/allow.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
        crossorigin="anonymous">
</head>
<body scroll="no">
    <?php
        session_start();
        if(!isset($_SESSION['userid']) && isset($_COOKIE['identifier']))
        $_SESSION['userid'] = $user['id'];{
        }
        if(!isset($_SESSION['userid'])) {
            header('location:info');
        }
        if(isset($_GET["key"])){
            $key = htmlspecialchars($_GET["key"]);        
            $pdo = new PDO("mysql:host=127.0.0.1;dbname=abikarten","web","vKf{DGl1WYon");

            $statement = $pdo->prepare("SELECT * FROM guests WHERE `qr` = :qr");
            $result = $statement->execute(array('qr' => $key));
            $guest = $statement->fetch();
        } else {
            header('location:info');
        }
    ?>
    <div id="header"style="background-color: 
                    <?php if($guest['entrance']): ?>
                        orange
                    <?php else: ?>
                        #4cD964
                    <?php endif; ?>">
        <div class="dot shadow" id="test">
            <a href="logout"><i class="fas fa-sign-out-alt"></a></i>
        </div>
    </div>

    <div id="main">   
        <div id="state" class="shadow"><p>Code erkannt</p></div>
        
        <div id="symbol"><i class="fas fa-check-circle" style="color: 
                    <?php if($guest['entrance']): ?>
                        orange
                    <?php else: ?>
                        #4cD964
                    <?php endif; ?>">
        </i></div>
        
        <div id="info" class="shadow">
            <p>
            Name: <?php echo($guest["name"]); ?><br>
            Schüler: <?php echo($guest["student"]); ?><br>
            Eingelassen:
            <?php if($guest['entrance']): ?>
                Ja
            <?php else: ?>
                Nein
            <?php endif; ?>
            </p>
        </div>
        <?php if($guest['entrance']): ?>
            <div id="button" class="shadow"><a href="functions?key=<?php echo($key);?>&entrance=0">Gegangen</a></div>
        <?php else: ?>
            <div id="button" class="shadow"><a href="functions?key=<?php echo($key);?>&entrance=1">Eingelassen</a></div>
        <?php endif; ?>
    </div>
</body>
</html>