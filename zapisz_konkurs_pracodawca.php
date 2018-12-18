
<!DOCTYPE html>
<?php
echo'<html lang="pl">
<head>';
include 'header.php';
echo'</head>
<body>';

    session_start();

    include 'logout.php';
    //include 'header.php';
    include 'polaczenie_do_bazy.php';
    echo'<div style="display: block; padding-right:42%;">
                <a class="btn btn-primary" style="color: white; float; right;"href="panel_pracodawca.php" role="button"><i class="fa fa-home"></i> PANEL PRACODAWCY</a>
            </div>';
    
    if (! empty($_POST)) {

        $nazwa_konkursu = $_POST['nazwa_konkursu'];
        $formularz_id = $_POST['formularz_id'];
        $opis_stanowiska = $_POST ['opis'];
        //echo $opis_stanowiska;
        if (! empty($_POST['konkurs_id'])) {
            $konkurs_id = $_POST['konkurs_id'];
        }

        $insert_update = $_POST['insert_update'];

        // dla nowego konkursu zrob wpis w tabeli konkursow i pobierz nowo utworzony konkurs id
        if ($insert_update == 'INSERT') {

            // zapisz konkurs do bazy (tabela konkursy prac)
            $insert_sql = 'INSERT INTO konkursy_pracodawcow (Formularze_idFormularze, Pracodawcy_idPracodawcy, Nazwa, Opis_Stanowiska)
	                       VALUES (' . $formularz_id . ', ' . $_SESSION['user_id'] . ' ,"' .  $nazwa_konkursu . '","' .$opis_stanowiska. '")'; 
            
            
            
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
               
        echo'<div style="clear:both;" class="defaultDiv defaultFont">';
        echo 'Zapisano konkurs: <b>' .$nazwa_konkursu.'</b>';
        
        
        //oblicz wage maksymalna
        $sql_maks_punktow = 'select oblicz_maks_punktow(' . $konkurs_id . ') as maks_punktow';
        $sql_maks_punktow_result = $conn->query($sql_maks_punktow);
        $row = mysqli_fetch_assoc($sql_maks_punktow_result);
        $maks_punktow = $row['maks_punktow'];
        
        $sql_update_maks_punktow = 'update konkursy_pracodawcow
                                   set maks_punktow = ' . $maks_punktow .',
                                       Opis_Stanowiska = "'.$opis_stanowiska .'"
                                    where idKonkursy_Pracodawcow = ' . $konkurs_id.'';
        
     
        
        if (! $sql_update_maks_punktow) {
            trigger_error('Invalid query: ' . $conn->error);
        }
        
        $sql_update_maks_punktow_result = $conn->query($sql_update_maks_punktow);
        
        
        
        echo "</br></br>";
        echo "Maksymalna ilość punktów do zdobycia: ";
        echo '<b>'.$maks_punktow.'</b>';
        echo "</br></br>";
        
    } else {}
    // przycisk powrotu do index.php
    
        
    echo ' <a href="panel_pracodawca.php" class="btn btn-primary">Wróć do panelu pracodawcy</a>
        </div>';
    include 'przycisk.php';
    echo'</body>
</html>';
    ?>