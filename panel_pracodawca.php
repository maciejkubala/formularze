<!doctype html>
<html lang="pl">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<!-- Dopasowanie szerokosci strony do urządzenia -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->

<link rel="stylesheet" type="text/css" href="style.css.php">

 
</head>
<body>
<!--     <script> -->
//         function myFunction() {
//             var x = document.getElementById("konkurs_id").value;
//             document.getElementById("opis_konkursu").innerHTML = "You selected: " + x;
//         }
 </script>
     <?php
    // Towrzy lub wznawia bier0zącą sesję
    session_start();

    include 'logout.php';
    include 'header.php';
    include 'polaczenie_do_bazy.php';

    if (isset($_POST['ilosc_osob'])) {
        echo '<LISTA STUDENTOW:>';
        echo $_POST['ilosc_osob'];
        for ($i = 1; $i <= $_POST['ilosc_osob']; $i ++) {
            echo 'Student:' . $i . '<br/>';
        }
    } else {

        echo '<div>';

        // wybierz swój konkurs i wpisz liczbe osób do wyswietlenia
        $sql_konkursy = 'SELECT idKonkursy_Pracodawcow, Nazwa FROM konkursy_pracodawcow WHERE Pracodawcy_idPracodawcy=' . $_SESSION['user_id'];
        $result = $conn->query($sql_konkursy);
        if ($result->num_rows > 0) {
            echo '<form method="post" action="istniejace_konkursy.php">';
            echo '<label for="konkurs_id">Twoje konkursy:</label>';
            echo '<select id="konkurs_id" name="konkurs_id">';
            while (     $row = $result->fetch_assoc()) { //
                $id = $row['idKonkursy_Pracodawcow'];
                $nazwa = $row['Nazwa'];
                echo '<option value="' . $id . '">' . $nazwa . '</option>';
            }
            echo '</select><br/>';
            echo '<label for="ilosc_osob">Ile osob wyswietlic?</label>';
            echo '<input type="number" id="ilosc_osob" name="ilosc_osob" required><br/>';
            echo '<input type="submit" class="option-input" style="width: 100px;" value="Zatwierdz">';
            echo '</form>';
            echo "<br><br><br><br>";
     
        }
    
        
        
//         echo '<p id="opis_konkursu">k </p>';
//         //wyswietl opis formularza
//         echo '<p><h3>Opis Konkursu:</h3></p>';
       
     
        // wybierz formularz i wpisz nazwe konkursu
        $sql_formularze = 'SELECT idFormularze, Nazwa FROM formularze';
        $result = $conn->query($sql_formularze);
        if ($result->num_rows > 0) {
            echo '<form method="post" action="formularz_pracodawca.php">';
            echo '<label for="formularz_id">Wybierz formularz</label>';
            echo '<select id="formularz_id" name= "formularz_id">';
            while ($row = $result->fetch_assoc()) { //
                $id = $row['idFormularze'];
                $nazwa = $row['Nazwa'];
                echo '<option value="' . $id . '">' . $nazwa . '</option>';
            }
            echo '</select><br/>';
            echo '<label for="nazwa_konkursu">Wpisz nazwe konkursu:</label>';
            echo '<input type="text" id="nazwa_konkursu" name="nazwa_konkursu" required><br/>';
            echo '<input type="submit" class="option-input" style="width: 100px;" value="Zatwierdz">';
            echo '</form>';
            echo '<br>';
        }

                        echo '<form method="post" action="sugestie.php">
                        <label for="sugestia">Jesli masz jakies uwagi/pytania/sugestie napisz do nas!</label>
                        <textarea name="sugestia" id"sugestia" rows="5" cols="40"></textarea>
                        <input type="submit" class="option-input" style="width: 100px;" value="Wyslij">
                        </form>';
        
        echo '</div>';
    }

    ?>
    

    <!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

<?php $conn->close(); ?>