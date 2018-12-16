
<!DOCTYPE html>
<?php
echo'<html>
<head>';
include 'header.php';
echo'</head>
<body>';


session_start();

include 'logout.php';

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
        echo '<div class="custom-control custom-radio custom-control-inline">';
        
        echo '<input type="radio" class="custom-control-input" id="' . $v_idPytania . '.'.$i.'" name= "pytanie[' . $v_idPytania . ']" value = "' . $i . '"' . $checked . '/>';
        echo '<label class="custom-control-label" for="' . $v_idPytania . '.'.$i.'">'.$i.'</lavel>';
      
        echo '</div>';
    }
    echo '</div>';
  

    $sqlOdpowiedziDoPytania = "SELECT Pytania_idPytania, idMozliwe_Odpowiedzi, Tresc FROM mozliwe_odpowiedzi WHERE Pytania_idPytania = '$v_idPytania'";
    $resultOdpowiedziDoPytania = $v_connection->query($sqlOdpowiedziDoPytania);
    if ($resultOdpowiedziDoPytania->num_rows > 0) {
        while ($row = $resultOdpowiedziDoPytania->fetch_assoc()) {

            $tresc = $row["Tresc"];
            $idMozliwe_Odpowiedzi = $row["idMozliwe_Odpowiedzi"];

            // generuj html dla pola input typu radio
            echo '<div class="row"><div style=" text-align:left; width:46%;"><li>' . $tresc . '</li></div>';
            echo ' <div>';             
            for ($i = 0; $i <= 10; $i ++) {
                if ($i == 5) {
                    $checked = 'checked="checked"';
                } else {
                    $checked = '';
                }
                
                echo '<div class="custom-control custom-radio custom-control-inline">';
                
                echo '<input type="radio" class="custom-control-input" id="' . $v_idPytania . '.'.$i.'.' . $idMozliwe_Odpowiedzi . '" name= "waga[' . $idMozliwe_Odpowiedzi . ']" value = "' . $i . '"' . $checked . '/>';
                echo '<label class="custom-control-label" for="' . $v_idPytania . '.'.$i.'.' . $idMozliwe_Odpowiedzi . '">'.$i.'</label>';
                
                echo '</div>';
                
                
                
                /* echo '<input type="radio" class="option-input radio" name= "waga[' . $idMozliwe_Odpowiedzi . ']" value = "' . $i . '"' . $checked . '/>' . $i; */
            }
            echo '</div></div>';
        }
    }
}


echo'<div style="display: block; padding-right:42%;">
                <a class="btn btn-primary" style="color: white; float; right;"href="panel_pracodawca.php" role="button"><i class="fa fa-home"></i>PANEL PRACODAWCY</a>
            </div>';

echo'<div class="defaultFont defaultDiv" style="display:">
               <h3> Zaznacz wagi pytań i odpowiedzi, aby stworzyć swój własny konkurs</h3>';
            


// jesli konkurs istnieje to wczytujemy istniejacy, w przeciwnym wypadku tworzymy nowy konkurs
if ($_POST) {

    // spróbuj pobrać konnkurs dla danego formularza
    $formularz_id = $_POST['formularz_id'];
    $nazwa_konkursu = $_POST['nazwa_konkursu'];
    $pracodawca_id = $_POST['user_id'];
    
    
    $select_opis = 'SELECT Opis_form_prac FROM formularze where idFormularze = ' .$formularz_id;
    $result_opis = $conn->query($select_opis);
    
    if (! $result_opis) {
        trigger_error('Invalid query: ' . $conn->error);
    }
    
    
    $row = mysqli_fetch_assoc($result_opis);
    $opis=$row["Opis_form_prac"];
    
    
    
    
                            
                            echo'<div style="border-top: solid 1px;">'. $opis.'</div></div>';
                            
                            echo '<div class="defaultDiv">';
                            
    
                            
                            
                            
    
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
       
       $select_opis = 'select Opis_Stanowiska  from konkursy_pracodawcow
                             where Formularze_idFormularze = ' . $formularz_id . '
                               and Pracodawcy_idPracodawcy = ' . $_SESSION['user_id'] . '
                               and Nazwa = "' . $nazwa_konkursu . '";';
       
       $result_opis = $conn->query($select_opis);
       
       if (! $result_opis)
       {
           trigger_error('Invalid query: ' . $conn->error);
           
       }
       
       $row = mysqli_fetch_assoc($result_opis);
       $opis = $row['Opis_Stanowiska'];
        echo '<div>';
        echo '<form style="text-align:center;" id="ankieta_pracodawca" method="post" action="zapisz_konkurs_pracodawca.php" >';
        echo '<label class  ="defaultFont" for="opis">Wpisz opis konkursu:</label>
                        <textarea class="form-control" name="opis" id="opis" maxlength="50" rows="5" cols="40">'.$opis.'</textarea>';
        echo '</br></br>';
        echo '</div>';
                  
        
        
        // wyswietl wagi pytan i odpowiedzi
        
       // echo '</div>';
        if ($result->num_rows > 0) {
            $nr = 1; // numeracja na stronie
            while ($row = $result->fetch_assoc()) {
                echo'<div class="defaultFont" style="border: solid 2px; border-radius: 25px; padding: 20px; margin-bottom: 10px;">';
                echo '<div  class="row" style=" border-bottom: solid 1px">';
                echo '<div style="width:46%; "><b>'.$nr . '.' . $row["TrescPytania"] .'</b></div>';
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
                    //echo '<input type="radio" class="option-input radio" name= "pytanie[' . $v_idPytania . ']" value = "' . $i . '"' . $checked . '/>' . $i;
                    
                    
                      echo '<div class="custom-control custom-radio custom-control-inline">';
                
                echo '<input type="radio" class="custom-control-input" id="' . $v_idPytania . '.'.$i.'" name= "pytanie[' . $v_idPytania . ']"" value = "' . $i . '"' . $checked . '/>';
                echo '<label class="custom-control-label" for="' . $v_idPytania . '.'.$i.'.">'.$i.'</label>';
                
                echo '</div>';
                
                     
                }
                
                echo '</div>';
                
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
                        echo '<div class="row"><div style="width: 46%; text-align: left;"><li>' . $tresc . '</li></div><div>';
                        for ($j = 0; $j <= 10; $j ++) {
                            if ($j == $rowOdpowiedzi["WagaOdpowiedzi"]) {
                                $checked = 'checked="checked"';
                            } else {
                                $checked = '';
                            }
                            echo '<div class="custom-control custom-radio custom-control-inline">';
                            
                            echo '<input type="radio" class="custom-control-input" id="' . $v_idPytania . '.'.$j.'.' . $idMozliwe_Odpowiedzi . '" name= "waga[' . $idMozliwe_Odpowiedzi . ']" value = "' . $j . '"' . $checked . '/>';
                            echo '<label class="custom-control-label" for="' . $v_idPytania . '.'.$j.'.' . $idMozliwe_Odpowiedzi . '">'.$j.'</label>';
                            
                            echo '</div>';
                        }
                        echo '</div></div>';
                    }
                    echo '</div>';
                }
                
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
        echo '<form style="text-align:center;" id="ankieta_pracodawca" method="post" action="zapisz_konkurs_pracodawca.php">';
        echo '<div>';
        echo '<label style="font-size:30;" class="defaultFont" for="opis">Wpisz opis konkursu:</label>
                        <textarea style="font-size:16px;" placeholder="Wpisz opis swojego konkursu." class="form-control" name="opis" id"opis" maxlength="50" rows="3" cols="40"></textarea>';
        echo '</br></br>';
        echo '</div>';
       
        
        if ($result->num_rows > 0) {
            $nr = 1; // numeracja na stronie
            while ($row = $result->fetch_assoc()) {
                // wyswietl tresc pytania stronie
             
                echo'<div class="defaultFont" style="border: solid 2px; border-radius: 25px; padding: 20px; margin-bottom: 10px;">';
                echo '<div  class="row" style=" border-bottom: solid 1px;">';
                echo '<div style="width:46%; "><b>'.$nr . '.' . $row["Tresc"] .'</b></div>';
                // wyswietl wagi pytan i odpowiedzi
                $nr ++;
                generujPytanie($row["idPytania"], $conn);
                echo '</div>';
              
            }
            
            echo "</table>";
        } else {
            echo "0 results";
        }
        echo '<input type="hidden"id="nazwa_konkursu" name="nazwa_konkursu" value="' . $nazwa_konkursu . '">';
        echo '<input type="hidden"id="formularz_id" name="formularz_id" value="' . $formularz_id . '">';
        echo '<input type="hidden"id="insert_update" name="insert_update" value="INSERT">';
        echo '<input type="submit" class="btn btn-primary" style="width: 100px;" value="Zatwierdź">';
        echo '</form>';
        echo '</div>';
        
    }
}
echo '</div>';
echo '</div></div>';
echo'<div id="footer"> <div class="row"><div style="padding:20px; margin-left:30%; margin-right:5%;">Strona internetowa została stworzona w ramach pracy inżynierskiej 2018!
            </div><b style="float:right; padding:20px;">Kontakt:</b><a style="  margin-right:auto;" href="www.facebook.pl/maciek.kubala.1" class="facebook fa fa-facebook"></a></div></div>';
echo'</div>';
echo'</body>
</html>';

$conn->close();
?>

