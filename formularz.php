
<!DOCTYPE html>
<html lang="pl">
<head>
<link rel="stylesheet" type="text/css" href="style.css.php">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<?php
session_start();

include 'header.php';

// -------------------------------
// POLACZENIE DO BAZY
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baza_formularzy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// -------------------------------

// na podstawie id pytania, pobierz do tego pytania odpowiedzi i wygeneruj kod html
function generujPytanie($v_idPytania, $v_connection)
{

    // zapytanie o odpowiedzi do pytania -> patrz parameter idPytania
    $sqlOdpowiedziDoPytania = "SELECT Pytania_idPytania, idMozliwe_Odpowiedzi, Tresc FROM mozliwe_odpowiedzi WHERE Pytania_idPytania = '$v_idPytania'";

    // wykonac sql
    $resultOdpowiedziDoPytania = $v_connection->query($sqlOdpowiedziDoPytania);

    // jesli sql cos zwrocil
    if ($resultOdpowiedziDoPytania->num_rows > 0) {
        // dla kazdego wiersza zwrĂłconego
        while ($row = $resultOdpowiedziDoPytania->fetch_assoc()) {
            // z wiersza pobieramy wartosci
            $tresc = $row["Tresc"];
            $idMozliwe_Odpowiedzi = $row["idMozliwe_Odpowiedzi"];

            if ($v_idPytania == 11 || $v_idPytania == 12 || $v_idPytania == 13) {
                if ($v_idPytania == 12 || $v_idPytania == 13) {
                    if ($v_idPytania == 12) {
                        $additional_class = 'limited-check';
                    } else {
                        $additional_class = 'limited-checkbox';
                    }
                } else {
                    $additional_class = '';
                }
                // TYP CHECKBOX/RADIOBUTTON KLASA , TABLICA
                echo '<input type="checkbox" class="option-input ' . $additional_class . '"  id="' . $v_idPytania . '" name="' . $v_idPytania . '[]" value="' . $idMozliwe_Odpowiedzi . '" >' . $tresc . '<br/>';
            } else {

                echo '<input type="radio" class="option-input radio" id="' . $v_idPytania . '" name="' . $v_idPytania . '" value="' . $idMozliwe_Odpowiedzi . '" >' . $tresc . '<br/>';
            }
        }
    }
}

// spradz najpierw czy student jest juz w bazie
$student = $_POST["indeks"];
$sqlIdStudenta = "SELECT idStudenci FROM studenci WHERE Nr_Indeksu = " . $student;
$result_sqlIdStudenta = $conn->query($sqlIdStudenta);
if ($result_sqlIdStudenta->num_rows > 0) {
    // jesli zapytanie zwrocilo rekord to znaczy student o takim numerze istnieje
    echo '<h2 style="color:red;">Student o numerze indeksu : ' . $student . ' już istnieje w bazie!</h2>';
    
} else {

    echo '<div>';
    // MAIN CODE STARTS HERE
    // poczatek strony
    echo "<h2>WITAJ STUDENCIE, WYPEŁNIJ ANKIETĘ</h2>";
    // pobierz liste pytan
    $sql = "SELECT idPytania, Tresc FROM Pytania";
    $result = $conn->query($sql);

    if (! $result) {
        trigger_error('Invalid query: ' . $conn->error);
    }
    $_SESSION["student"] = $student;

    echo '<div>';
    echo '<form id="ankieta_student" method="post" action="zapisz_ankiete.php">';
    // jesli zapytanie zwrĂłcilo wiersze
    if ($result->num_rows > 0) {
        // dopoki sa wiersze
        // wyswietl kazde pytanie
        $nr = 1;
        while ($row = $result->fetch_assoc()) {

            // wyswietl pytanie na stronie
            echo $nr . ". " . $row["Tresc"] . "<br>";
            // wyswietl odpowiedzi do pytania
            $nr ++;
            generujPytanie($row["idPytania"], $conn);

            echo "<br>";
        }

        echo "</table>";
    } else {
        echo "0 results";
    }
    echo '<input type="hidden" id="type" name="type" value="' . $_POST["type"] . '">';
    echo '<input type="submit" class="option-input" style="width: 100px;" value="Zatwierdz">';
    echo '</form>';
    echo '</div>';
    echo '</div>';
}
$conn->close();
?>
<script>
var limit = 4;
$('input.limited-check').on('change', function(evt){
	if($('input.limited-check:checked').length > limit) {
		this.checked = false;
		}	
});
	
	$('input.limited-checkbox').on('change', function(evt){
		if($('input.limited-checkbox:checked').length > limit) {
			this.checked = false;
			}	
	});
</script>
</body>
</html>