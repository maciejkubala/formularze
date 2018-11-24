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
    if (isset($_SESSION['user_id'])) {
        
        include 'logout.php';
    
    } else {
        //wyswietl formularz wyboru student/pracodawca
        echo '<form method="post" action="login.php">
        <label for="type">Witaj, kim jesteś?:</label>
        <select name="type" id="type">
        <option value="student">Student</option>
        <option value="pracodawca">Pracodawca</option>
        </select><br/>
        <input type="submit" class="option-input" style="width: 100px;" value="Zatwierdź">
        </form>';
        echo "maciek";
    }
    ?>
   

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>