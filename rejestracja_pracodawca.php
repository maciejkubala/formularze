<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="style.css.php">
   <title>boom</title>
  </head>
  <body>
  
<?php

include 'header.php';

if(!isset($_POST['email'])) {
    $email = "";
}

if(!isset($_POST['login'])) {
    $login = "";
}
//-------------------------------
// POLACZENIE DO BAZY

error_reporting(E_ALL);
ini_set('display_errors', '1');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baza_formularzy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");


function filtruj($zmienna) 
{
    global $conn;
    
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna); // usuwamy slashe

	// usuwamy spacje, tagi html oraz niebezpieczne znaki
        return mysqli_real_escape_string($conn, htmlspecialchars(trim($zmienna))); 
}

if (isset($_POST['rejestruj'])) 
{
	$login = filtruj($_POST['login']);
	$haslo1 = filtruj($_POST['haslo1']);
	$haslo2 = filtruj($_POST['haslo2']);
	$email = filtruj($_POST['email']);
	$ip = filtruj($_SERVER['REMOTE_ADDR']);
	
	//Valid email!
	if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		// sprawdzamy czy login nie jest ju� w bazie
    	if (mysqli_num_rows($conn->query("SELECT Nazwa FROM pracodawcy WHERE Nazwa = '".$login."';")) == 0) 
    	{
    	    if (mysqli_num_rows($conn->query("SELECT Nazwa FROM pracodawcy WHERE email = '".$email."';")) == 0) 
    	    {
    	        
    	        $uppercase = preg_match('@[A-Z]@', $haslo1);
    	        $lowercase = preg_match('@[a-z]@', $haslo1);
    	        $number    = preg_match('@[0-9]@', $haslo1);
    	        
    	        if($uppercase && $lowercase && $number && strlen($haslo1) > 9) {
    	        
        	        if ($haslo1 == $haslo2) // sprawdzamy czy hasła takie same
            		{
            		    $md5haslo=md5($haslo1);
             		    $sql = "INSERT INTO pracodawcy
                                 (idPracodawcy, Nazwa, haslo, email, ip, Data_Rejestracji, Data_Logowania)
                                 VALUES (null, '$login', '$md5haslo', '$email', '$ip', NOW(), NOW());";
            		    $result = $conn->query($sql);
            		    
            		    if (!$result) {
            		        trigger_error('Invalid query: ' . $conn->error);
            		    }
            
            			echo "Konto zostało utworzone!";
            			echo "<br>";
            			echo "<br>";
            			echo('<a href="logowanie_pracodawca.php" class="label" style="width: 150px; text-decoration: none;">Idź do strony logowania</a>');
            			
            		}
        		    else echo "<p style='color:red;'>Hasła nie są takie same.</p>";
    	        }
    	        else echo "<p style='color:red;'>Hasło musi mieć minimum 8 znaków, w tym duże i małe litery i cyfry</p>";
    	    }
    	    else echo "<p style='color:red;'>Podany email jest już wprowadzony.</p>";
    	}
    	else echo "<p style='color:red;'>Podany login jest już zajęty.</p>";
	}
	else echo "<p style='color:red;'>Niepoprawny adres email.</p>";
}

echo '<form name="formRejestracja" method="POST" action="rejestracja_pracodawca.php">
        <b>Login:</b> <input type="text" name="login"value="'.$login.'"><br>
        <b>Hasło:</b> <input type="password" name="haslo1"><br>
        <b>Powtórz hasło:</b> <input type="password" name="haslo2"><br>
        <b>Email:</b> <input type="text" id="email" name="email" value="'.$email.'"><br>
        <input type="submit" value="Zarejestruj" name="rejestruj">
      </form>';

?>


	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
<?php $conn->close(); ?>