<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
  </head>
  <body>

<?php
session_start();
echo'<div style="display: block; padding-right:42%;">
                <a class="btn btn-primary" style="color: white; float; right;"href="index.php" role="button"><i class="fa fa-home"></i> HOME</a>
            </div>';
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
echo'<div style="text-align: center;  margin-top: 10px;" id="header" class="defaultDiv">';
echo'<div class="defaultFont" style="font-weight: 700;">Pracodawco!
            </div>';

echo'<div class="defaultFont" style="display: inline-block;">
                Wpisz login i hasło, aby zalogować się do swojego konta.
                </div>';
echo'</div>';

function filtruj($zmienna) 
{
    global $conn;
    
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna); // usuwamy slashe

	// usuwamy spacje, tagi html oraz niebezpieczne znaki
        return mysqli_real_escape_string($conn, htmlspecialchars(trim($zmienna))); 
}
echo'<div class="defaultDiv defaultFont" style="width: 50%;">
<form method="POST" action="logowanie_pracodawca.php">
<b>Login:</b> 
<input type="text" class="form-control" placeholder="Wpisz swój login" name="login"><br>
<b>Hasło:</b> <input type="password" class="form-control" placeholder="Wpisz swoje hasło" name="haslo"><br>
<input type="hidden" id="type" class="form-control" name="type" value="pracodawca">
<input type="hidden" id="user_id" class="form-control" name="user_id" value="pracodawca">
<input type="submit" class="btn btn-primary" value="Zaloguj" name="loguj">
</form>';
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
	
	else echo '</br><b style="color: RGB(0,0,0); background-color: RGBA(207,0,1,0.67);">Wpisano złe dane.</b>';
}
echo '<div></br><b  style=" font-weight: 400; display:inline-block; ">Nie posiadasz swojego konta? Zarejestruj się teraz: </b>';
echo '</div>';
echo '<div style="display:inline-block;"><a class="btn btn-primary" style=" display: inline-block; margin-top: 25px;" href="rejestracja_pracodawca.php">Rejestracja</a>';
echo '</div>';
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

echo '</div></div>';
echo'<div id="footer"> <div class="row"><div style="padding:20px; margin-left:30%; margin-right:5%;">Strona internetowa została stworzona w ramach pracy inżynierskiej 2018!
            </div><b style="float:right; padding:20px;">Kontakt:</b><a style="  margin-right:auto;" href="www.facebook.pl/maciek.kubala.1" class="facebook fa fa-facebook"></a></div></div>';
echo'</div>';
?>

<?php 

if (isset($_SESSION['zalogowany'])==0 || $_SESSION['zalogowany']==false) :

?>




<?php endif;
 ?>    
 
  </body>
</html>

<?php $conn->close(); ?>