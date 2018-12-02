
<!DOCTYPE html>
<html lang="pl">
<head>
<link rel="stylesheet" type="text/css" href="style.css.php">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>


<?php
session_start();

include 'header.php';

if(empty($_POST)) {
    include 'logout.php';
}

include 'polaczenie_do_bazy.php';

// na podstawie id pytania, pobierz do tego pytania odpowiedzi i wygeneruj kod html
function generujPytanie($v_idPytania, $v_connection, $v_typ, $v_ilosc_wyborow)
{

    // zapytanie o odpowiedzi do pytania -> patrz parameter idPytania
    $sqlOdpowiedziDoPytania = "SELECT Pytania_idPytania, idMozliwe_Odpowiedzi, Tresc FROM mozliwe_odpowiedzi WHERE Pytania_idPytania = '$v_idPytania'";

    // wykonac sql
    $resultOdpowiedziDoPytania = $v_connection->query($sqlOdpowiedziDoPytania);

    // jesli sql cos zwrocil
    if ($resultOdpowiedziDoPytania->num_rows > 0) {
        // dla kazdego wiersza zwracanego
        echo '<div>';
        while ($row = $resultOdpowiedziDoPytania->fetch_assoc()) {
            // z wiersza pobieramy wartosci
            $tresc = $row["Tresc"];
            $idMozliwe_Odpowiedzi = $row["idMozliwe_Odpowiedzi"];

            
            // TYP CHECKBOX/RADIOBUTTON KLASA , TABLICA
            if ($v_typ == 'C') {
                // jesli inne dodaj input box
                if($tresc == "Inne") {
                    echo '<input type="checkbox" class="option-input limited-check-' . $v_idPytania . '"  id="inne' . $v_idPytania . '" name="' . $v_idPytania . '[]" value="' . $idMozliwe_Odpowiedzi . '" onclick="javascript:showHideInput' . $v_idPytania . '();">' . $tresc . '<br/>';
                    echo '<div id="div' . $v_idPytania . '" style="display:none"><input type="text" style="width:500px;" id="inne' . $v_idPytania . 'odp' . $idMozliwe_Odpowiedzi . '" name="inne' . $v_idPytania . 'odp' . $idMozliwe_Odpowiedzi . '"></div>';
                } else {
                    echo '<input type="checkbox" class="option-input limited-check-' . $v_idPytania . '"  id="' . $v_idPytania . '" name="' . $v_idPytania . '[]" value="' . $idMozliwe_Odpowiedzi . '">' . $tresc . '<br/>';
                }
            } 
            if ($v_typ == 'R') {
                echo '<input type="radio" class="option-input radio" id="' . $v_idPytania . '" name="' . $v_idPytania . '" value="' . $idMozliwe_Odpowiedzi . '" >' . $tresc . '<br/>';
            }
            
        }
        echo '</div>';
    }
}

// spradz najpierw czy student jest juz w bazie
$user_id = $_POST["user_id"];
$formularz_id = $_POST["formularz_id"];

$sqlIdStudenta = "SELECT distinct s.idStudenci, pf.Formularze_idFormularze
                   FROM odpowiedzi_studentow os
                   join studenci s on os.Studenci_idStudenci = s.idStudenci
                   join pytania_z_formularzy pf on pf.idPytania_Z_Formularzy = os.Pytania_Z_Formularzy_idPytania_Z_Formularzy
                  where Nr_Indeksu = " . $user_id . " and pf.Formularze_idFormularze = " . $formularz_id;

$result_sqlIdStudenta = $conn->query($sqlIdStudenta);
if ($result_sqlIdStudenta->num_rows > 0) {
    // jesli zapytanie zwrocilo rekord to znaczy student o takim numerze istnieje
    echo '<h3 style="color:red;">Student o numerze indeksu ' . $user_id . ' już wypełnił ten formularz!</h3>';
    
} else {

    $_SESSION["user_id"] = $user_id;
    $_SESSION["type"] = "student";
    $formularz_id = $_POST["formularz_id"];
    
    // generuj javaskrypty do walidacji wypełnienia pól
    echo '<script type="text/javascript">';
    echo 'function checkFormData() {';
    echo "\r\n";
    $sql_idPytania = "SELECT idPytania, Tresc, Typ FROM v_pytania_z_formularza where idFormularze = " .$formularz_id;
        $result_idPytania = $conn->query($sql_idPytania);
        if ($result_idPytania->num_rows > 0) {
            while ($row = $result_idPytania->fetch_assoc()) {

                $checkbox_name = $row["idPytania"];
                $pytanie = $row["Tresc"];
                $typ = $row["Typ"];
                
                if ($typ == 'R') {
                    echo ' if (!$(\'input[name=' . $checkbox_name .']:checked\').length > 0) {';
                }
                if ($typ == 'C') {
                    echo ' if (!$(\'input[name="' . $checkbox_name .'[]"]:checked\').length > 0) {';
                }
                echo '  document.getElementById("errMessage").innerHTML = "Pytanie \"' . $pytanie . ' \" nie moze byc puste";';
                echo '  return false;';
                echo ' }';
                echo "\r\n";
                echo "\r\n";
                
            }
        }
        echo ' return true;';
        echo '}';
        echo "\r\n";
        echo "\r\n";
        echo '</script>';
        
    // generuj javaskrypty do pola inne
        echo '<script type="text/javascript">';
        $sql_inne = "SELECT idPytania 
                       FROM v_pytania_z_formularza pf
                       join mozliwe_odpowiedzi mo on mo.Pytania_idPytania = pf.idPytania
                      where pf.idFormularze = " . $formularz_id . " 
                        and mo.Tresc = 'Inne'";
        $result_inne = $conn->query($sql_inne);
        if ($result_inne->num_rows > 0) {
            while ($row = $result_inne->fetch_assoc()) {

                $idPytania = $row["idPytania"];
                
                echo 'function showHideInput' . $idPytania . '() {';
                echo "\r\n";

                echo '    if (document.getElementById(\'inne' . $idPytania . '\').checked) {';
                echo '        document.getElementById(\'div' . $idPytania . '\').style.display = \'block\';';
                echo '    }';
                echo '    else document.getElementById(\'div' . $idPytania . '\').style.display = \'none\';';
                echo '}';
                
                echo "\r\n";
                echo "\r\n";
                
            }
        }
        echo "\r\n";
        echo '</script>';
        
        
   
    echo '<div>';
    // MAIN CODE STARTS HERE
    // poczatek strony
    echo "<h2>WITAJ STUDENCIE, WYPEŁNIJ ANKIETĘ</h2>";
    
    // pobierz liste pytan
    $sql = "SELECT idPytania, Tresc, Typ, ilosc_wyborow FROM v_pytania_z_formularza where idFormularze = " .$formularz_id;
    $result = $conn->query($sql);

    if (! $result) {
        trigger_error('Invalid query: ' . $conn->error);
    }

    echo '<div>';
    echo '<form id="ankieta_student" name="ankieta_student" method="post" action="zapisz_ankiete_student.php" onsubmit="return checkFormData()">';
    // jesli zapytanie zwrócilo wiersze
    if ($result->num_rows > 0) {
        // dopoki sa wiersze
        // wyswietl kazde pytanie
        $nr = 1;
        while ($row = $result->fetch_assoc()) {

            // wyswietl pytanie na stronie
            echo $nr . ". " . $row["Tresc"];
            // wyswietl odpowiedzi do pytania
            $nr ++;
            generujPytanie($row["idPytania"], $conn,  $row["Typ"], $row["ilosc_wyborow"]);

        }

    } else {
        echo "0 results";
    }
    echo '<input type="hidden" id="formularz_id" name="formularz_id" value="' . $formularz_id . '">';
    echo '<input type="hidden" id="type" name="type" value="' . $_POST["type"] . '">';
    echo '<input type="hidden" id="user_id" name="user_id" value="' . $_POST["user_id"] . '">';
    // tekst do walidacji pytań
    echo '<p style="color:red;" id="errMessage"></p>';

    echo '<input type="submit" id="przycisk" class="option-input" style="width: 100px;" value="Zatwierdz">';
    echo '</form>';
    echo '</div>';
    echo '</div>';
     }
 
     
     
     //generuj javaskrpyty do ilosci zaznaczenia checkboxow
     echo '<script>';
     $sql_checkboxy = "SELECT idPytania, ilosc_wyborow FROM v_pytania_z_formularza where idFormularze = " .$formularz_id . " and Typ = 'C'";
     $result_checkboxy = $conn->query($sql_checkboxy);
     if ($result_checkboxy->num_rows > 0) {
         while ($row = $result_checkboxy->fetch_assoc()) {
             
             $idPytania = $row["idPytania"];
             $ilosc_wyborow = $row["ilosc_wyborow"];
             
             echo '$(\'input.limited-check-' . $idPytania . '\').on(\'change\', function(evt){';
             echo '    if($(\'input.limited-check-' . $idPytania . ':checked\').length > ' . $ilosc_wyborow .') {';
             echo '      this.checked = false;';
             echo '    }';
             echo '});';
             echo "\r\n";
             echo "\r\n";
             
         }
     }
     
     echo '</script>';
     
     
     
$conn->close();

?>

</body>
</html>