<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- <meta http-equiv="refresh" content="10" > -->
    
	<link rel="stylesheet" type="text/css" href="style.css">	
  </head> 	
 <body>
    <?php 
   
    include 'polaczenie_do_bazy.php';
    session_start();
    if (isset($_SESSION['user_id'])) {
        
        include 'logout.php';
        if($_SESSION['type'] == 'pracodawca') {
            header("Location: panel_pracodawca.php");
        }else{
            
            $_SESSION['zalogowany'] = false;
            session_destroy();
            $url = "index.php";
            header("Location: ".$url);
            die();
        }
        
       
    
    } else {
        
        echo'<div id="container">';
        //tu będziemy przechowywać wszystko co ogólne
        
        echo'<div id="header">';
        //Tu będzie przycisk home i napis powitalny!
        
        echo'<div style="float:left;">
                <form method="post" action="login_student.php">
                <button type="button" class="btn">HOME</button>
                </div>';
        
        echo'<div style="text-align:center; font-size: 24px; text-shadow: 8px 5px 8px rgba(0,0,0,0.81); ">
                Witaj!
                Znajdujesz się na stronie internetowej stworzonej w celu zbierania informacji od studentów PWr poprzez ankiety
                oraz tworzenia własnego systemu punktowego do stworzonych ankiet.
                </div>';
        
        echo'</div>';
        
        echo'<div id="central">';
        //pojemnik na przechowanie napisu wyboru i selecta
        
        echo'<div style="float: left;">';
        echo '<form method="post" action="login_student.php">
              <label for="type">Kim jesteś?:</label>
              <select name="type" class="custom-select" id="type">
              <option value="student">Student</option>
              <option value="pracodawca">Pracodawca</option>
              </select><br/>
              <input type="submit" class="option-input" style="width: 100px;" value="Zatwierdź">
              </form>';
        
        echo'</div>';
        
        echo'<div style="clear:both;">';
        echo'</div>';
        echo'</div>';
        
        echo'<div id="footer">';
        //tu będą informacje/ kontakt do autora oraz że strona została zrobiona w ramach pracy inżynierskiej 2018 PWr!
        echo'</div>';
        
        echo'</div>';
        
        
        
        
        //wyswietl formularz wyboru student/pracodawca
        /* echo'<div id="menu">';
        echo'<div id="napis">';
        echo '<form  method="post" action="login_student.php">
        <label for="type">Witaj, kim jesteś?:</label>
        <select name="type" id="type">
        <option value="student">Student</option>
        <option value="pracodawca">Pracodawca</option>
        </select><br/>
        <input type="submit" class="option-input" style="width: 220px;" value="Zatwierdź">
        </form>';
        echo'</div>';
        echo'</div>'; */
    }
    ?>
   

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>