<?php 
session_start();
$pdo = new PDO("mysql:host=127.0.0.1;dbname=abikarten","web","vKf{DGl1WYon");

if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    
    $statement = $pdo->prepare("SELECT * FROM users WHERE user = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
        
    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['id'];
        setcookie("identifier",random_string(),time()+(3600*24*365)); //Valid for 1 year
        sleep(2);
        header('location:http://ohg-abi.de');
    } else {
        $errorMessage = "Nutzername oder Passwort war ungültig<br>";
    }
    
}
function random_string() {
	if(function_exists('openssl_random_pseudo_bytes')) {
		$bytes = openssl_random_pseudo_bytes(16);
		$str = bin2hex($bytes); 
	} else if(function_exists('mcrypt_create_iv')) {
		$bytes = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
		$str = bin2hex($bytes); 
	} else {
		//Replace your_secret_string with a string of your choice (>12 characters)
		$str = md5(uniqid('your_secret_string', true));
	}	
	return $str;
}
?>
<!DOCTYPE html> 
<html> 
<head>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OHG-Abi 20</title>
    <link rel="stylesheet" type="text/css" href="/css/login/login.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
        crossorigin="anonymous"> 
</head> 
<body scroll="no">
 
    <?php 
    if(isset($errorMessage)) {
        echo $errorMessage;
    }
    ?> 

    <div class="holder">
        <form action="?login=1" method="post" class="holder">
            
            <div class="user-input-wrp">
                <input type="text" id="inputMail" name="email" class="input" required/>
                <span class="floating-label-mail">Nutzername <i class="fas fa-user"></i></i></span>
                
                <input type="password" id="inputPassword" name="passwort" class="input" required/>
                <span class="floating-label-password">Passwort <i class="fas fa-lock"></i></span>

                <input type="submit" value="Abschicken" id="submit">
            </div>
        </form> 
    </div> 
</body>
</html>
