
<!DOCTYPE html>
<html lang="pl">
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>


<?php
session_start();



/* echo('<a href="login_student.php" style="width: 400px; text-decoration: none;"><span>&#8592;</span></a>'); */

if(empty($_POST)) {
    include 'logout.php';
}


echo'<div style="display: block; padding-right:42%;">
                <a class="btn btn-primary" style="color: white; float; right;"href="panel_pracodawca.php" role="button"><i class="fa fa-home"></i>HOME</a>
            </div>';

echo'<div class="defaultFont defaultDiv" style="display:">
             <div style="border-bottom: solid 1px;">  <h3> Wypełnij ankietę</h3></div>';

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
        $x=0;
        
        while ($row = $resultOdpowiedziDoPytania->fetch_assoc()) {
            // z wiersza pobieramy wartosci
            $tresc = $row["Tresc"];
            $idMozliwe_Odpowiedzi = $row["idMozliwe_Odpowiedzi"];
            
            // TYP CHECKBOX/RADIOBUTTON KLASA , TABLICA
            if ($v_typ == 'C') {
                // jesli inne dodaj input box
                if($tresc == "Inne") {      
                    echo '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input limited-check-' . $v_idPytania . '"  id="inne' . $v_idPytania . '" name="' . $v_idPytania . '[]" value="inne' . $idMozliwe_Odpowiedzi . '" onclick="javascript:showHideInput' . $v_idPytania . '();">
                        <label class="custom-control-label" for="inne' . $v_idPytania . '">' . $tresc . '</label>              
                        </div>';
                    echo '<div id="div' . $v_idPytania . '" style="display:none"><input type="text" class="form-control" id="inne' . $v_idPytania . 'odp' . $idMozliwe_Odpowiedzi . '" name="inne' . $v_idPytania . 'odp' . $idMozliwe_Odpowiedzi . '"></div>';
                   } else {
                    echo '<div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input limited-check-' . $v_idPytania . '"  id="' . $v_idPytania . ''.$x.'" name="' . $v_idPytania . '[]" value="' . $idMozliwe_Odpowiedzi . '">
                    <label class="custom-control-label" for="' . $v_idPytania . ''.$x.'">' . $tresc . '</label>
                    </div>';
                }
            } 
            if ($v_typ == 'R') {                
                echo '<div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="' . $v_idPytania . ''.$x.'" name="' . $v_idPytania . '" value="' . $idMozliwe_Odpowiedzi . '" >
                    <label class="custom-control-label" for="' . $v_idPytania . ''.$x.'">' . $tresc . '</label>
                    </div>';
            }
            $x++;
        }
        echo '</div>';
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
    echo'</br>';
    echo '<div class="defaultFont"><h3>Przepraszamy: Student o numerze indeksu ' . $user_id . ' już wypełnił tę ankietę!</h3>';

    echo ' <form action="login_student.php" method=\'post\' enctype="multipart/form-data">';
    echo ' <input type="hidden" id="type" name="type" value="' . $_POST["type"] . '">';
    echo ' <input type="hidden" id="user_id" name="user_id" value="' . $_POST["user_id"] . '">';
    echo ' <input type="submit"  class="btn btn-primary" name="submit" value="Wróć"/>';
    echo ' </form>';
    echo '</div></div>';
    echo'<div id="footer"> <div class="row"><div style="padding:20px; margin-left:30%; margin-right:5%;">Strona internetowa została stworzona w ramach pracy inżynierskiej 2018!
            </div><b style="float:right; padding:20px;">Kontakt:</b><a style="  margin-right:auto;" href="www.facebook.pl/maciek.kubala.1" class="facebook fa fa-facebook"></a></div></div>';
    echo'</div>';
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
                echo '  document.getElementById("errMessage").innerHTML = "Pytanie \"' . $pytanie . ' \" nie moze byc puste.";';
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
    
        $select_opis = 'SELECT Opis_form_stud FROM formularze where idFormularze = ' .$formularz_id;
        $result_opis = $conn->query($select_opis);
    
        if (! $result_opis) {
            trigger_error('Invalid query: ' . $conn->error);
        }
        
        
        $row = mysqli_fetch_assoc($result_opis);
        $opis=$row["Opis_form_stud"];
        
        echo '</h4>Witaj w ankiecie dotyczącej pierwszego zatrudnienia!</h4> 
        </br>Zasady wypełnia ankiety:</br> 
        <div style="text-align:center;"><b>1.</b>W pytaniach 1-10;14-17 zaznacz jedną prawidłową odpowiedź.</br> 
        <b>2.</b>W pytaniu 11 zaznacz wszystkie prawidłowe odpowiedzi.</br>
        <b>3.</b>W pytaniach 12-13 zaznacz 1-4 odpowiedzi.</div>';
        echo'</div>';
        echo'<div class="defaultDiv defaultFont" style="text-align: left;">';
    
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
            echo '<div style="border: solid 2px; border-radius: 25px; padding: 20px; margin-bottom: 10px;" >'.$nr . '. ' . $row["Tresc"].'';
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
    echo '<p style="color:red;  font-weight:500; text-align:center;" id="errMessage"></p>';

    echo '<div style="text-align:center;"><input type="submit" id="przycisk" class="btn btn-primary" style="width: 100px;" value="Zatwierdź"></div>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
     }
 
     
     
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
             
             echo 'var maxSelected' . $idPytania . ' = 0;';
             echo "\r\n";
             echo 'function showHideInput' . $idPytania . '() {';
             echo "\r\n";
             
             echo '    if (document.getElementById(\'inne' . $idPytania . '\').checked  && maxSelected' . $idPytania . '==0) {';
             echo '        document.getElementById(\'div' . $idPytania . '\').style.display = \'block\';';
             echo '    }';
             echo '    else{ document.getElementById(\'div' . $idPytania . '\').style.display = \'none\';
                                                document.getElementById(\'div' . $idPytania . '\').value="";}';
             echo '}';
             
             echo "\r\n";
             echo "\r\n";
             
         }
     }
     echo "\r\n";
//      echo '</script>';
     
     
     //generuj javaskrpyty do ilosci zaznaczenia checkboxow
//      echo '<script>';
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
             
             echo "if ($('input.limited-check-" . $idPytania . ":checked').length >= " . $ilosc_wyborow .") {";
             echo "    maxSelected" . $idPytania . " = 1;";
             echo "} else {";
             echo "    maxSelected" . $idPytania . " = 0;";
             echo "}";
             
             echo '});';
             echo "\r\n";
             echo "\r\n";
             
         }
     }
     
     echo '</script>';
     
     echo '</div></div>';
     echo'<div id="footer"> <div class="row"><div style="padding:20px; margin-left:30%; margin-right:5%;">Strona internetowa została stworzona w ramach pracy inżynierskiej 2018!
            </div><b style="float:right; padding:20px;">Kontakt:</b><a style="  margin-right:auto;" href="www.facebook.pl/maciek.kubala.1" class="facebook fa fa-facebook"></a></div></div>';
     echo'</div>';
     
$conn->close();

?>

</body>
</html>