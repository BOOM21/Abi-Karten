<?php

    if(isset($_GET["key"])){
        $key= htmlspecialchars($_GET["key"]);
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=abikarten","web","vKf{DGl1WYon");
        $statement = $pdo->prepare("UPDATE guests SET entrance = :entrance WHERE qr = :qr");
        if(isset($_GET["entrance"])){
            echo("Entrance:".$_GET["entrance"]);
            $result = $statement->execute(array('entrance' => $_GET["entrance"],'qr' => $key));
        }
        header('location:allow?key='.$key);
    } else {
        header('location:info');
    }

?>