<!doctype html>
<html lang="pl">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<!-- Dopasowanie szerokosci strony do urządzenia -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>
<body>

     <?php
    // Towrzy lub wznawia bier0zącą sesję
    session_start();

    include 'logout.php';
//include 'header.php';
    include 'polaczenie_do_bazy.php';

    if (isset($_POST['ilosc_osob'])) {
        echo '<LISTA STUDENTOW:>';
        echo $_POST['ilosc_osob'];
        for ($i = 1; $i <= $_POST['ilosc_osob']; $i ++) {
            echo 'Student:' . $i . '<br/>';
        }
    } else {

           echo'<div style="display: block; padding-right:42%;">
                <a class="btn btn-primary" style="color: white; float; right;"href="panel_pracodawca.php" role="button"><i class="fa fa-home"></i> PANEL PRACODAWCY</a></br>   
            </div>';
        
        echo'<div style=" margin-top: 20px; margin-bottom: 20px;text-align:center; "id="header" class="defaultDiv">';
        
        
        echo'<div class="defaultFont" style="display: inline-block;">
               <h1> PANEL PRACODAWCY:</h1>
 Na podstawie stworzonych punktacji do ankiet (konkursów), możesz wyznaczyć ranking studentów. W panelu możesz również usówać konkursy oraz wysyłać wiadomości do admina. 
            </div>';
        
        echo'</div>';
        echo '<div>';

        // wybierz swój konkurs i wpisz liczbe osób do wyswietlenia
        $sql_konkursy = 'SELECT idKonkursy_Pracodawcow, Nazwa FROM konkursy_pracodawcow WHERE Pracodawcy_idPracodawcy=' . $_SESSION['user_id'];
        $result = $conn->query($sql_konkursy);
        if ($result->num_rows > 0) {
           echo '<div class="row" style="margin-top: 20px; margin-bottom: 20px; width: 100%;">
            <div class="defaultDiv" style="text-align: center; width: 30%;">
            <b class="defaultFont" style="font-weight:700;"> Tworzenie listy studentów </b>
            <form method="post" action="istniejace_konkursy_pracodawca.php" style="text-align: center;">';
            echo '<label class="defaultFont"for="konkurs_id">Twoje konkursy:</label>';
            echo '<select class="form-control" id="konkurs_id" name="konkurs_id">';
            while (     $row = $result->fetch_assoc()) { 
                $id = $row['idKonkursy_Pracodawcow'];
                $nazwa = $row['Nazwa']; 
                echo '<option value="' . $id . '">' . $nazwa . '</option>';
            }
            echo '</select><br/>';
            echo '<label class="defaultFont"for="ilosc_osob">Ilość studentów:</label>';
            echo '<input type="number" class="form-control" min="1" max="50" id="ilosc_osob" name="ilosc_osob" required><br/><br/><br/>';
            echo '<input type="submit" class="btn btn-primary" style="width: 80%; margin-top: 20px;" value="Stwórz">';
            echo '</form>';
            echo "</div>";
        }
        }

        
        // wybierz formularz i wpisz nazwe konkursu
        $sql_formularze = 'SELECT idFormularze, Nazwa FROM formularze';
        $result = $conn->query($sql_formularze);
        if ($result->num_rows > 0) {
        /*     echo '<div class="row" style="margin-top: 20px; margin-bottom: 20px;"> */
                   echo' <div class="defaultDiv" style=" text-align: center; width: 30%;">
                    <b class="defaultFont">Utwórz/edytuj konkurs:</b>';
            //echo '<br>';
            echo '<form method="post" action="formularz_pracodawca.php" style="text-align: center;">';
            echo '<label class="defaultFont" for="formularz_id">Wybierz formularz</label>';
            echo '<select id="formularz_id" class="form-control" name= "formularz_id">';
            while ($row = $result->fetch_assoc()) { //
                $id = $row['idFormularze'];
                $nazwa = $row['Nazwa'];
                echo '<option value="' . $id . '">' . $nazwa . '</option>';
            }
            echo '</select><br/>';
            echo '<label class="defaultFont" for="nazwa_konkursu">Wpisz nazwe konkursu:</label>';
            echo '<input type="text" class="form-control" id="nazwa_konkursu" name="nazwa_konkursu" required><br/><br/><br/><br/>';
            echo '<input type="submit" class="btn btn-primary" style="width: 80%;" value="Zatwierdź">';
            echo '</form>';
            echo '</div>';
        }
        
        
        //delete
                
        $sql_konkursy = 'SELECT idKonkursy_Pracodawcow, Nazwa FROM konkursy_pracodawcow WHERE Pracodawcy_idPracodawcy=' . $_SESSION['user_id'];
        $result = $conn->query($sql_konkursy);
        if ($result->num_rows > 0) {
            echo '<div class="defaultDiv" style="width: 30%; text-align:center;">
            <b class="defaultFont"> Twoje konkursy</b></br></br>
            <form method="post" action="usun_konkurs_pracodawca.php" style="text-align: center;">';
            echo '<label class="defaultFont" for="konkurs_id">Wybierz konkurs</label></br>';
            echo '<select class="form-control" id="konkurs_id" name="konkurs_id">';
            while (     $row = $result->fetch_assoc()) {
                $id = $row['idKonkursy_Pracodawcow'];
                $nazwa = $row['Nazwa'];
                echo '<option value="' . $id . '">' . $nazwa . '</option>';
            }
            echo '</select><br/>';
            echo '<input type="submit" class="btn btn-primary" style="width: 80%; margin-top:40%;" value="Usuń">';
            echo '</form></div>';
        }
     
//                  SUGESTIE
                    echo '<div class="defaultDiv defaultFont" style="margin-top: 20px; margin-bottom: 20px;width: 30%;">
                        <form method="post" action="sugestie.php">
                        <label for="sugestia" style="font-weight:500;">Jesli masz jakies uwagi/pytania/sugestie napisz do nas!</label>
                        <textarea name="sugestia" id="sugestia" rows="5" cols="40" maxlength="100" style="width:100%;"></textarea>
                        <input type="submit" class="btn btn-primary" style="width: 80%; margin-top: 5%;" value="Wyślij">
                        </form>
                        </div></br></br>';
                    
            echo '</div></div>';
            echo'<div id="footer"> <div class="row"><div style="padding:20px; margin-left:30%; margin-right:5%;">Strona internetowa została stworzona w ramach pracy inżynierskiej 2018!
            </div><b style="float:right; padding:20px;">Kontakt:</b><a style="  margin-right:auto;" href="www.facebook.pl/maciek.kubala.1" class="facebook fa fa-facebook"></a></div></div>';
            echo'</div>';
    ?>
    
</body>
</html>

<?php $conn->close(); ?>