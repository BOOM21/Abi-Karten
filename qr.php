<?php
    session_start();
    if(isset($_GET["key"])){
        $key = htmlspecialchars($_GET["key"]);      
        if(!isset($_SESSION['userid']) && isset($_COOKIE['identifier'])){
            $_SESSION['userid'] = $user['id'];
        }
        if(!isset($_SESSION['userid'])) {
            header('location:info');
        } else {  
            $pdo = new PDO("mysql:host=127.0.0.1;dbname=abikarten","web","vKf{DGl1WYon");

            $statement = $pdo->prepare("SELECT * FROM guests WHERE `qr` = :qr");
            $result = $statement->execute(array('qr' => $key));
            $guest = $statement->fetch();
            
            if($guest !== false){
                header('location:allow?key='.$key);
            } else {
                header('location:deny');
            }
        }
    } else {
        header('location:info');
    }
?>