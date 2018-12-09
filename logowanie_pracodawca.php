<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="style.css.php">
    
  </head>
  <body>

<?php
session_start();
include 'header.php';
include 'polaczenie_do_bazy.php';
?>

<?php
if (isset($_GET['wyloguj'])==1) 
{
       $_SESSION['zalogowany'] = false;
	   session_destroy();
}
?>

<?php
function filtruj($zmienna) 
{
    global $conn;
    
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna); // usuwamy slashe

	// usuwamy spacje, tagi html oraz niebezpieczne znaki
        return mysqli_real_escape_string($conn, htmlspecialchars(trim($zmienna))); 
}

if (isset($_POST['loguj'])) 
{
	$login = filtruj($_POST['login']);
	$haslo = filtruj($_POST['haslo']);
	$ip = filtruj($_SERVER['REMOTE_ADDR']);
	
	// sprawdzamy czy login i has�o s� dobre
	if (mysqli_num_rows($conn->query("SELECT Nazwa, haslo FROM pracodawcy WHERE Nazwa = '".$login."' AND haslo = '".md5($haslo)."';")) > 0) 
	{	
		// uaktualniamy date logowania oraz ip
		mysqli_query("UPDATE `pracodawcy` SET (`logowanie` = '".time().", `ip` = '".$ip."'') WHERE Nazwa = '".$login."';");
	
		$_SESSION['zalogowany'] = true;
		$_SESSION['user_id'] = $login;
		$_SESSION['type'] = "pracodawca";
		// zalogowany
		
		// pobierz id pracodawcy
		$sql_select ='SELECT idPracodawcy, Nazwa FROM pracodawcy WHERE Nazwa = "' .$login. '"';
		$result = $conn->query($sql_select);
		if ($result->num_rows > 0) {//sprawdzamy czy liczba wierszy jest większa od 0
		    while ($row = $result->fetch_assoc()) {//
		      $user_id = $row['idPracodawcy'];
		    }
		}
		

	}
	else echo "Wpisano złe dane.";
}

if (isset($_SESSION['zalogowany'])==1) {
    if ($_SESSION['zalogowany']==true)
    {
    	
        $_SESSION["user_id"] = $user_id;
        $_SESSION['type'] = "pracodawca";
        $url = "panel_pracodawca.php";
        header("Location: ".$url);
        die();
     
    }
}
?>

<?php 

if (isset($_SESSION['zalogowany'])==0 || $_SESSION['zalogowany']==false) :

?>

<form method="POST" action="logowanie_pracodawca.php">
<b>Login:</b> <input type="text" name="login"><br>
<b>Hasło:</b> <input type="password" name="haslo"><br>
<input type="hidden" id="type" name="type" value="pracodawca">
<input type="hidden" id="user_id" name="user_id" value="pracodawca">
<input type="submit" value="Zaloguj" name="loguj">
</form> 

<a href="rejestracja_pracodawca.php">[Zarejestruj]</a>

<?php endif;
 ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>

<?php $conn->close(); ?>