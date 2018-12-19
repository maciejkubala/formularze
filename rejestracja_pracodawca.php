<!DOCTYPE html>
<?php
echo'<html lang="pl">
<head>';
include 'header.php';
echo'<title>Rejestracja</title>';
echo'</head>
<body>';
//include 'header.php';
include 'polaczenie_do_bazy.php';
$przeszloWalidacje=true;
echo'<div style="display: block; padding-right:42%;">
                <a class="btn btn-primary" style="color: white; float; right;"href="index.php" role="button"><i class="fa fa-home"></i> HOME</a>
            </div>';
echo'<div style="text-align: center;" id="header" class="defaultDiv">';
echo'<div class="defaultFont" style="font-weight: 700;">Pracodawco!
            </div>';

echo'<div class="defaultFont" style="display: inline-block;">
                W celu rejestracji nowego konta wypełnij poniższy formularz.
                </div>';
echo'</div>';

if(!isset($_POST['email'])) {
    $email = "";
}

if(!isset($_POST['login'])) {
    $login = "";
}
echo '<div class="defaultDiv defaultFont" style="width: 50%">
    <form name="formRejestracja" method="POST" action="rejestracja_pracodawca.php">';
//-------------------------------
// POLACZENIE DO BAZY

/* error_reporting(E_ALL);
ini_set('display_errors', '1');
 */
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
	
	
	//każde pole musi być wypełnione
	if( (!empty($login)) && (!empty($email)) && (!empty($haslo1)) && (!empty($haslo2))){
	    //Valid email!
	    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		// sprawdzamy czy login nie jest ju� w bazie
    	if (mysqli_num_rows($conn->query("SELECT Nazwa FROM pracodawcy WHERE Nazwa = '".$login."';")) == 0) 
    	{
    	    if (mysqli_num_rows($conn->query("SELECT Nazwa FROM pracodawcy WHERE email = '".$email."';")) == 0) 
    	    {
    	        //czy zawiera
    	        $uppercase = preg_match('@[A-Z]@', $haslo1);
    	        $lowercase = preg_match('@[a-z]@', $haslo1);
    	        $number    = preg_match('@[0-9]@', $haslo1);
    	        
    	        if($uppercase && $lowercase && $number && strlen($haslo1) >= 8) {
    	        
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
            
            			echo '<div class="defaultFont" style="font-weight:700;">Konto zostało utworzone!</div>';
            			$przeszloWalidacje = false;
            			echo "<br>";
            			

            			
            		}
            		else echo '<div class="alert alert-danger" style=" display:block; color: RGB(0,0,0); background-color: RGBA(207,0,1,0.67);"><strong>Wystąpił błąd: </strong>Hasła muszą być takie same.</div>';
    	        }
   	        else echo '<div class="alert alert-danger" style="display:block; color: RGB(0,0,0); background-color: RGBA(207,0,1,0.67);"><strong>Wystąpił błąd: </strong>Hasło musi mieć minimum 8 znaków, w tym cyfry oraz małe i duże litery.</div>';
    	    }
    	    else echo '<div class="alert alert-danger" style="display:block; color: RGB(0,0,0); background-color: RGBA(207,0,1,0.67);"><strong>Wystąpił błąd: </strong>Podany email istnieje już w bazie.</div>';
    	}
    	else echo '<div class="alert alert-danger" style="display:block; color: RGB(0,0,0); background-color: RGBA(207,0,1,0.67);"><strong>Wystąpił błąd: </strong>Podany login jest już zajęty.</div>';
	}
	else echo '<div class="alert alert-danger" style="display:block; color: RGB(0,0,0); background-color: RGBA(207,0,1,0.67);"><strong>Wystąpił błąd: </strong>Niepoprawny adres email!</div>';
}
else echo '<div class="alert alert-danger" style=" display:block; color: RGB(0,0,0); background-color: RGBA(207,0,1,0.67);"><strong>Wystąpił błąd: </strong>Żadne pole nie może być puste!</div>';
}

if($przeszloWalidacje){
 echo'  <b>Login:</b> <input class="form-control" type="text" name="login" placeholder="Wpisz swój login" value="'.$login.'"><br>
        <b>Hasło:</b> <input class="form-control" type="password" name="haslo1" placeholder="Min.8 znaków, w tym: cyfra,małe i duże litery"><br>
        <b>Powtórz hasło:</b> <input class="form-control" type="password" name="haslo2" placeholder="Powtórz hasło"><br>
        <b>Email:</b> <input class="form-control" type="text" id="email" name="email" placeholder="Wpisz swój adres email" value="'.$email.'"><br>
        <input class="btn btn-primary" type="submit" value="Zarejestruj" name="rejestruj">
        
      </form>';
}else{
    echo'   <a href="logowanie_pracodawca.php" class="btn btn-primary">Idź do strony logowania</a>';
}
   echo'   </div>';
   echo '</div></div>';
   include 'przycisk.php';
?>
	<?php 
	echo'
  </body>
</html>';
	?>
<?php $conn->close(); ?>