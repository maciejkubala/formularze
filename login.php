<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="style.css.php">
    
    <script type = "text/javascript" >
    	function sprawdz(){
        		var f = document.forms.indeks;
				//var indeks = /^\(?([0-9]{6}\$/;
				
				if(f.indeks.value.length > 6 || f.indeks.value.length < 6 ){
					alert('Niepoprawny numer indeksu!');
					return;
					}
		f.submit();		
        }
    </script>
  </head>
  <body>
    
    

    <?php
    
    include 'header.php';
    //wlacz zmienne sesyjne
//    session_start();
    //jesli ktos sie loguje to wchodzi tutaj
//     if(!empty($_POST) && isset($_POST["login"]) && isset($_POST["password"])) {
//             $login = $_POST["login"];
//             $password = $_POST["password"];
//             if($login == "maciek" && $password == "1234") {
//                 //poprawnie zalogowany - przejdz do panelu pracodawcy
//                 $_SESSION["user"] = $login;
//                 $_SESSION["user_id"] = 15;
//                 $url = "panel_pracodawca.php";
                
//                 header("Location: ".$url);
//                 //die();
//             } else {
//                 //jesli niepoprawne dane logowania to odswiez strone
//                 $url = "login.php";
//                 header("Location: ".$url);
//                 //die();
//             }
//         } else {
            //jesli wybrano student to wykonaj kod ponizej
            //czemu 2 razy to samo??
            
            if(!empty($_POST["type"]) && $_POST["type"] == "student") {
                echo '<form method="post" action="formularz.php">
                    	<label for="indeks">Numer indeksu:</label>
                    	<input id="indeks" name="indeks" type="text" required><br/>
                        <input type="hidden"id="type" name="type" value="' . $_POST["type"]. '">
                    	<input type="button" class="option-input" style="width: 100px;" value="Zatwierdź" onclick="sprawdz()">
                    
                    </form>';
            } else {
                   $url = "logowanie.php";
                   header("Location: ".$url);
                   die();
                   
                   
                   
                
                //wyswietl formularz logowania
//                 echo '<form method="post" action="login.php">
//                     	<label for="login">Login:</label>
//                     	<input id="login" name="login" required><br/>
//                     	<label for="password">Password:</label>
//                     	<input id="password" name="password" type="password" required><br/>
//                     	<input type="submit" class="option-input" style="width: 100px;" value="Login">
//                     </form>';
            }
            
            
//         }
    
    ?>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>