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
    } else if(isset($_POST["name"])){
        $name = $_POST["name"];
        $student = $_POST["student"];
        $qr = uniqid("", true);
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=abikarten","web","vKf{DGl1WYon");
        $statement = $pdo->prepare("INSERT INTO guests (name, student, qr) VALUES (?, ?, ?)");
        $statement->execute(array($name, $student, $qr)); 
        header('location:guests');
    } else if(isset($_GET["remove"])){
        $qr = $_GET["remove"];
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=abikarten","web","vKf{DGl1WYon");
        $statement = $pdo->prepare("DELETE FROM guests WHERE qr = '".$qr."'");
        $statement->execute(); 
        header('location:guests');
    } else {
        header('location:info');
    }

?>