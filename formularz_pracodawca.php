
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css.php">
</head>
<body>

<?php
session_start();

include 'logout.php';
include 'header.php';
include 'polaczenie_do_bazy.php';

// -------------------------------

// na podstawie id pytania, pobierz do tego pytania odpowiedzi i wygeneruj kod html
function generujPytanie($v_idPytania, $v_connection)
{

    for ($i = 0; $i <= 10; $i ++) {
        if ($i == 5) {
            $checked = ' checked="checked"';
        } else {
            $checked = '';
        }
        echo '<input type="radio" class="option-input radio" name= "pytanie[' . $v_idPytania . ']" value = "' . $i . '"' . $checked . '/>' . $i;
    }

    echo '</br><br/>';

    $sqlOdpowiedziDoPytania = "SELECT Pytania_idPytania, idMozliwe_Odpowiedzi, Tresc FROM mozliwe_odpowiedzi WHERE Pytania_idPytania = '$v_idPytania'";
    $resultOdpowiedziDoPytania = $v_connection->query($sqlOdpowiedziDoPytania);
    if ($resultOdpowiedziDoPytania->num_rows > 0) {
        while ($row = $resultOdpowiedziDoPytania->fetch_assoc()) {

            $tresc = $row["Tresc"];
            $idMozliwe_Odpowiedzi = $row["idMozliwe_Odpowiedzi"];

            // generuj html dla pola input typu radio
            echo '<li>' . $tresc . '</li>';
            for ($i = 0; $i <= 10; $i ++) {
                if ($i == 5) {
                    $checked = 'checked="checked"';
                } else {
                    $checked = '';
                }
                echo '<input type="radio" class="option-input radio" name= "waga[' . $idMozliwe_Odpowiedzi . ']" value = "' . $i . '"' . $checked . '/>' . $i;
            }
            echo '</br><br/>';
        }
    }
}


echo '<div>';
echo "<h2>WITAJ PRACODAWCO, ZAZNACZ WAGI PYTAN</h2>";

// jesli konkurs istnieje to wczytujemy istniejacy, w przeciwnym wypadku tworzymy nowy konkurs
if ($_POST) {

    // spróbuj pobrać konnkurs dla danego formularza
    $formularz_id = $_POST['formularz_id'];
    $nazwa_konkursu = $_POST['nazwa_konkursu'];
    $pracodawca_id = $_POST['user_id'];
    
    $sql_konkurs_pracodawcy = 'SELECT idKonkursy_Pracodawcow 
                                 FROM konkursy_pracodawcow 
                                WHERE Formularze_idFormularze="' . $formularz_id . 
                               '" AND Nazwa = "' . $nazwa_konkursu . 
                               '" AND Pracodawcy_idPracodawcy = "' . $pracodawca_id . '";';
                                     
    $result = $conn->query($sql_konkurs_pracodawcy);
    
    // jesli konkurs istnieje to wczytaj istniejący konkurs
    if ($result->num_rows > 0) {

        // pobierz liste wag dla danego konkursu
        $sql_wagi = 'SELECT distinct idKonkursy_Pracodawcow, NazwaKonkursu, Pracodawcy_idPracodawcy, idFormularze, idPytania, TrescPytania, WagaPytania 
                       FROM v_wagi_konkursu 
                      WHERE idFormularze = ' .$formularz_id .
                      ' AND NazwaKonkursu = "' . $nazwa_konkursu .
                     '" AND Pracodawcy_idPracodawcy = ' . $pracodawca_id . ';';
        $result = $conn->query($sql_wagi);
        
        if (! $result) {
            trigger_error('Invalid query: ' . $conn->error);
        }
        
        echo '<div>';
        echo '<form id="ankieta_pracodawca" method="post" action="zapisz_konkurs.php">';
        if ($result->num_rows > 0) {
            $nr = 1; // numeracja na stronie
            while ($row = $result->fetch_assoc()) {
                // wyswietl tresc pytania stronie
                echo $nr . ". " . $row["TrescPytania"] . "<br>";
                $nr ++;

                $konkurs_id = $row["idKonkursy_Pracodawcow"];
                
                $v_idPytania = $row["idPytania"];
                // wyswietl wagi pytan i odpowiedzi
                for ($i = 0; $i <= 10; $i ++) {
                    if ($i == $row["WagaPytania"]) {
                        $checked = ' checked="checked"';
                    } else {
                        $checked = '';
                    }
                    echo '<input type="radio" class="option-input radio" name= "pytanie[' . $v_idPytania . ']" value = "' . $i . '"' . $checked . '/>' . $i;
                    
                }

                echo '</br><br/>';
                
                //wyswietl odpowiedzi do pytania
                $sqlOdpowiedziDoPytania = 'SELECT distinct idKonkursy_Pracodawcow, NazwaKonkursu, Pracodawcy_idPracodawcy, idFormularze, idMozliwe_Odpowiedzi, TrescOdpowiedzi, WagaOdpowiedzi
                                             FROM v_wagi_konkursu
                                            WHERE idFormularze = ' .$formularz_id .
                                            ' AND NazwaKonkursu = "' . $nazwa_konkursu .
                                           '" AND Pracodawcy_idPracodawcy = ' . $pracodawca_id . 
                                           '  AND idPytania = ' . $v_idPytania .
                                           ';';
                
                $resultOdpowiedziDoPytania = $conn->query($sqlOdpowiedziDoPytania);
                if ($resultOdpowiedziDoPytania->num_rows > 0) {
                    while ($rowOdpowiedzi = $resultOdpowiedziDoPytania->fetch_assoc()) {
                        
                        $tresc = $rowOdpowiedzi["TrescOdpowiedzi"];
                        $idMozliwe_Odpowiedzi = $rowOdpowiedzi["idMozliwe_Odpowiedzi"];
                        
                        // generuj html dla pola input typu radio
                        echo '<li>' . $tresc . '</li>';
                        for ($j = 0; $j <= 10; $j ++) {
                            if ($j == $rowOdpowiedzi["WagaOdpowiedzi"]) {
                                $checked = 'checked="checked"';
                            } else {
                                $checked = '';
                            }
                            echo '<input type="radio" class="option-input radio" name= "waga[' . $idMozliwe_Odpowiedzi . ']" value = "' . $j . '"' . $checked . '/>' . $j;
                        }
                        echo '</br><br/>';
                    }
                }
                    
                
                echo "<br><br><br><br>";
            }
            
            echo "</table>";
        } else {
            echo "0 results";
        }
        echo '<input type="hidden"id="konkurs_id" name="konkurs_id" value="' . $konkurs_id . '">';
        echo '<input type="hidden"id="nazwa_konkursu" name="nazwa_konkursu" value="' . $nazwa_konkursu . '">';
        echo '<input type="hidden"id="formularz_id" name="formularz_id" value="' . $formularz_id . '">';
        echo '<input type="hidden"id="insert_update" name="insert_update" value="UPDATE">';
        echo '<input type="submit" class="option-input" style="width: 100px;" value="Zatwierdź">';
        echo '</form>';
        echo '</div>';
        
    } else {
    // wyswietl strone nowego kunkursu
    
        // pobierz liste pytan dla danego formualrza
        $sql_pytania = 'select idPytania, Tresc from v_pytania_z_formularza where idFormularze = ' .$formularz_id .';' ;
        $result = $conn->query($sql_pytania);
        
        if (! $result) {
            trigger_error('Invalid query: ' . $conn->error);
        }

        echo '<div>';
        echo '<form id="ankieta_pracodawca" method="post" action="zapisz_konkurs.php">';
        if ($result->num_rows > 0) {
            $nr = 1; // numeracja na stronie
            while ($row = $result->fetch_assoc()) {
                // wyswietl tresc pytania stronie
                echo $nr . ". " . $row["Tresc"] . "<br>";
                // wyswietl wagi pytan i odpowiedzi
                $nr ++;
                generujPytanie($row["idPytania"], $conn);

                echo "<br><br><br><br>";
            }
            
            echo "</table>";
        } else {
            echo "0 results";
        }
        echo '<input type="hidden"id="nazwa_konkursu" name="nazwa_konkursu" value="' . $nazwa_konkursu . '">';
        echo '<input type="hidden"id="formularz_id" name="formularz_id" value="' . $formularz_id . '">';
        echo '<input type="hidden"id="insert_update" name="insert_update" value="INSERT">';
        echo '<input type="submit" class="option-input" style="width: 100px;" value="Zatwierdź">';
        echo '</form>';
        echo '</div>';
        
    }
}
echo '</div>';
$conn->close();
?>

</body>
</html>