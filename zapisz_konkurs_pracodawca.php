<!doctype html>
<html lang="pl">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    
    <?php
    session_start();

    include 'logout.php';
    include 'header.php';
    include 'polaczenie_do_bazy.php';

    if (! empty($_POST)) {

        $nazwa_konkursu = $_POST['nazwa_konkursu'];
        $formularz_id = $_POST['formularz_id'];
        $opis_stanowiska = $_POST ['opis'];
        echo $opis_stanowiska;
        if (! empty($_POST['konkurs_id'])) {
            $konkurs_id = $_POST['konkurs_id'];
        }

        $insert_update = $_POST['insert_update'];

        // dla nowego konkursu zrob wpis w tabeli konkursow i pobierz nowo utworzony konkurs id
        if ($insert_update == 'INSERT') {

            // zapisz konkurs do bazy (tabela konkursy prac)
            $insert_sql = 'INSERT INTO konkursy_pracodawcow (Formularze_idFormularze, Pracodawcy_idPracodawcy, Nazwa, Opis_Stanowiska)
	                       VALUES (' . $formularz_id . ', ' . $_SESSION['user_id'] . ' ,"' .  $nazwa_konkursu . '","' .$opis_stanowiska. '")'; 
            echo $insert_sql;
            
            
            $update_opis = '';
            $insert_result = $conn->query($insert_sql);
            
            if (! $insert_result) {
                trigger_error('Invalid query: ' . $conn->error);
            }

            // pobierz nowo utworzony konkurs id
            $sql_konkurs = 'select idKonkursy_Pracodawcow
                              from konkursy_pracodawcow 
                             where Formularze_idFormularze = ' . $formularz_id . '
                               and Pracodawcy_idPracodawcy = ' . $_SESSION['user_id'] . '                               
                               and Nazwa = "' . $nazwa_konkursu . '"
                               and Opis_Stanowiska = "' . $opis_stanowiska .'"';
            $sql_konkurs_result = $conn->query($sql_konkurs);

            if (! $sql_konkurs_result) {
                trigger_error('Invalid query: ' . $conn->error);
            }

            if ($sql_konkurs_result->num_rows > 0) {
                while ($row = $sql_konkurs_result->fetch_assoc()) {
                    $konkurs_id = $row["idKonkursy_Pracodawcow"];
                }
            }
        }
        
        // zapis wagi pytan i odpowiedzi po wypelnionym
        if (! empty($_POST['pytanie']) && ! empty($_POST['waga'])) {
            // zapisz wagi pytan z ankiety pracodawcy
            foreach ($_POST['pytanie'] as $nr => $wartosc) {
                if ($insert_update == 'INSERT') {
                    $insert_sql = 'INSERT INTO wagi_pytan
                                    (Konkursy_Pracodawcow_idKonkursy_Pracodawcow, Pytania_idPytania, Wagi)
                                    VALUES (' . $konkurs_id . ', ' . $nr . ', ' . $wartosc . ')';
                    $insert_result = $conn->query($insert_sql);
                } else {
                    $update_sql = 'UPDATE wagi_pytan
                                      SET Wagi = ' . $wartosc . ' WHERE Konkursy_Pracodawcow_idKonkursy_Pracodawcow = ' . $konkurs_id . ' AND Pytania_idPytania = ' . $nr;
                    $update_result = $conn->query($update_sql);
                }
                
            }

            // zapisz wagi odpowiedzi z ankiety pracodawcy
            foreach ($_POST['waga'] as $nr => $wartosc) {
                if ($insert_update == 'INSERT') {
                    $insert_sql = 'INSERT INTO wagi_odpowiedzi
                                (Konkursy_Pracodawcow_idKonkursy_Pracodawcow, Mozliwe_Odpowiedzi_idMozliwe_Odpowiedzi, Wagi)
                                VALUES (' . $konkurs_id . ', ' . $nr . ', ' . $wartosc . ')';
                    $insert_result = $conn->query($insert_sql);
                } else {
                    $update_sql = 'UPDATE wagi_odpowiedzi
                                      SET Wagi = ' . $wartosc . ' WHERE Konkursy_Pracodawcow_idKonkursy_Pracodawcow = ' . $konkurs_id . ' AND Mozliwe_Odpowiedzi_idMozliwe_Odpowiedzi = ' . $nr;
                    $update_result = $conn->query($update_sql);
                }
            }
        }

        //nazwa konkursu potrzebne wszystko ? 
        $select_nazwa_konkursu= 'SELECT Nazwa, maks_punktow
                                     FROM konkursy_pracodawcow
                                    WHERE idKonkursy_Pracodawcow= ' . $konkurs_id;
        
        $result_nazwa_konkursu = $conn->query($select_nazwa_konkursu);
        
        
        $row = mysqli_fetch_assoc($result_nazwa_konkursu);
        $nazwa_konkursu = $row['Nazwa'];
               
        
        echo 'Zapisano konkurs: "' .$nazwa_konkursu.'"';
        
        
        //oblicz wage maksymalna
        $sql_maks_punktow = 'select oblicz_maks_punktow(' . $konkurs_id . ') as maks_punktow';
        $sql_maks_punktow_result = $conn->query($sql_maks_punktow);
        $row = mysqli_fetch_assoc($sql_maks_punktow_result);
        $maks_punktow = $row['maks_punktow'];
        
        $sql_update_maks_punktow = 'update konkursy_pracodawcow
                                   set maks_punktow = ' . $maks_punktow .',
                                       Opis_Stanowiska = "'.$opis_stanowiska .'"
                                    where idKonkursy_Pracodawcow = ' . $konkurs_id.'';
        
        echo $sql_update_maks_punktow;
        
        if (! $sql_update_maks_punktow) {
            trigger_error('Invalid query: ' . $conn->error);
        }
        
        $sql_update_maks_punktow_result = $conn->query($sql_update_maks_punktow);
        
        
        
        echo "</br></br>";
        echo "Maksymalna wartosc punktow: ";
        echo $maks_punktow;
        echo "</br></br>";
        
    } else {}
    // przycisk powrotu do index.php
    
        
    echo ('<a href="panel_pracodawca.php" class="option-input" style="width: 150px; text-decoration: none;">Wroc do panelu pracodawcy</a><br/><br/><br/>');
    ?>

    <!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>