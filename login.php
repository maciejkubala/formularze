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

	<script type="text/javascript">
    	function sprawdz() {
        	var f = document.forms.formularzIndeks;
        	var index_error_text;
				if(isNaN(f.indeks.value) || f.indeks.value.length != 6 ){
					text = 'Niepoprawny numer indeksu!';
					document.getElementById("index_error_message").innerHTML = text;
					return;
				}
				f.submit();	
        }
    </script>    

    <?php
    include 'header.php';

    echo '<p style="color:red;" id="index_error_message"></p>';

    if (! empty($_POST["type"]) && $_POST["type"] == "student") {
        echo '<form method="post" action="formularz.php" name="formularzIndeks">
            	<label for="indeks">Numer indeksu:</label>
            	<input id="indeks" name="indeks" type="text" required><br/>
                <input type="hidden"id="type" name="type" value="' . $_POST["type"] . '">
            	<input type="button" class="option-input" style="width: 100px;" value="Zatwierdź" onclick="sprawdz()">                    
              </form>';
    } else {
        $url = "logowanie.php";
        header("Location: " . $url);
        die();
    }

    ?>
    
    <!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>