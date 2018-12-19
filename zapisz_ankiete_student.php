<!DOCTYPE html>
<?php 
echo'<html lang="pl">
<head>';
include 'header.php';
echo'</head>
<body>';
     session_start();
    
   // include 'header.php';
    include 'polaczenie_do_bazy.php';
    include 'logout.php';
   
    //znajdz id studenta o numerze inkdeksu z session
// nie wpisujemy 2 razy tego samego nr indeksu
    $sqlIdStudenta = "SELECT idStudenci FROM studenci WHERE Nr_Indeksu = ".$_SESSION['user_id'];
    $resultIdStudenta = $conn->query($sqlIdStudenta);
    
// fetch_assoc() czy mysqli_fetch_assoc
    if ($resultIdStudenta->num_rows > 0) {
        while ($row = $resultIdStudenta->fetch_assoc()) {
           
              $id=$row["idStudenci"];     
        }
    }
//studenta nie ma jeszcze w bazie 
    if(empty($id)){
        
        $select_id_student ='INSERT INTO `studenci` (`Nr_Indeksu`, `Data_Wypelnienia`) VALUES ('.$_SESSION['user_id'].', NOW());';
        $resultInsertStudent = $conn->query($select_id_student);
        if (! $resultInsertStudent) {
            trigger_error('Invalid query: ' . $conn->error);
        }
        
        $sqlIdStudenta = "SELECT idStudenci FROM studenci WHERE Nr_Indeksu = ".$_SESSION['user_id'];
        
        $resultIdStudenta = $conn->query($sqlIdStudenta);
        
        if ($resultIdStudenta->num_rows > 0) {
            while ($row = $resultIdStudenta->fetch_assoc()) {
                
                $id=$row["idStudenci"];      
            }
        }
    }

//funkcja pobierająca id pytania z tabeli pytania z formularzy 
    function pobierz_id_pytania_z_formularzy($v_id_pytania, $v_id_formularza, $v_connection) {

        $sql_id_pytania_z_formularzy = "SELECT idPytania_Z_Formularzy 
                                          FROM pytania_z_formularzy 
                                         WHERE Formularze_idFormularze = " . $v_id_formularza . "
                                          AND Pytania_idPytania = " . $v_id_pytania;
            
// wykonac sql
        $result_id_pytania_z_formularzy = $v_connection->query($sql_id_pytania_z_formularzy);
        $row = mysqli_fetch_assoc($result_id_pytania_z_formularzy);
        return $row['idPytania_Z_Formularzy'];
        
    }
    
    if(!empty($_POST)) {
        
        if(isset($_POST["formularz_id"])) {
            $formularz_id = $_POST["formularz_id"];
        }
        
        //zapisz odpowiedzi studenta z ankiety
        //iteruj po wszystkich parametrach post
        foreach($_POST as $key => $value) {
            
            if($key == "formularz_id" || $key == "type" || $key == "user_id") {
                // pomiń powyższe parametry
            }
            //wchodzi dla inne
            elseif((substr($key, 0, 4) == "inne")) {
//                 echo("INNE key: ".$key." value: ".$value."<br/>");
//                  echo '<br>';
//                 echo 'inne';
				// wyciągnięcie id pytania inne12odp123 inne12 - inne = 12                
                $id_pytania = substr($key, 4, strpos($key, 'o') - 4);
                
                //pobierz id pytania przypisanego do formularza
                $id_pytania_z_formularzy = pobierz_id_pytania_z_formularzy($id_pytania, $formularz_id, $conn);

//                 echo 'id_pytania = ' . $id_pytania;
//                 echo '<br>';
                //wyciągnięcie odpowiedzi  inne123odp156= 13   - inne123odp =10 - zwróc 3 ostatnie cyfry
                $id_odpowiedzi = substr($key, strpos($key, 'o') + 3, strlen($key) - (strpos($key, 'o') + 3));
//                 echo 'id_odpowiedzi = ' . $id_odpowiedzi;
                $sql_insert = 'INSERT INTO odpowiedzi_studentow (`Studenci_idStudenci`, `Pytania_Z_Formularzy_idPytania_Z_Formularzy`, `Mozliwe_Odpowiedzi_idMozliwe_Odpowiedzi`,
                             `Odpowiedz_tekstowa`)
                                VALUES('.$id.','.$id_pytania_z_formularzy.', ' . $id_odpowiedzi . ', "'.$value.'")';
//                  echo '<br>';
//                  echo $sql_insert;
                $insert_result = $conn->query($sql_insert);
                if (! $insert_result) {
                    trigger_error('Invalid query: ' . $conn->error);
                }
                
            }
            elseif (is_array($value)){
                
//                 foreach($value as $odpowiedz) {
//                     echo 'checkbox value = ' . $odpowiedz, '<br>';
//                 }
//                 echo '<br>';
//                 echo 'checkbox';

                //pobierz id pytania przypisanego do formularza
                $id_pytania_z_formularzy = pobierz_id_pytania_z_formularzy($key, $formularz_id, $conn);
                
                //dla kaædej wartosci  z tablicy value // rozbij tablice na pojedyncze odpowiedzi wpisz do tabeli
                foreach($value as $odpowiedz){
                    //omieniecie podwojonego zapisywania inne
                    if ((substr($odpowiedz, 0, 4) != "inne")) {
                        $sql_insert = 'INSERT INTO odpowiedzi_studentow (`Studenci_idStudenci`, `Pytania_Z_Formularzy_idPytania_Z_Formularzy`, `Mozliwe_Odpowiedzi_idMozliwe_Odpowiedzi`)
                                VALUES('.$id.','.$id_pytania_z_formularzy.','.$odpowiedz.')';
    //                     echo '<br>';
    //                     echo '$sql_insert = ' . $sql_insert;
                        $insert_result = $conn->query($sql_insert);
                        if (! $insert_result) {
                            trigger_error('Invalid query: ' . $conn->error);
                        }
                    }
                }
            }
            elseif (is_numeric($value)){
//                 echo '<br>';
//                 echo 'radio';

                //pobierz id pytania przypisanego do formularza
                $id_pytania_z_formularzy = pobierz_id_pytania_z_formularzy($key, $formularz_id, $conn);
//                 echo '$id_pytania_z_formularzy = ' . $id_pytania_z_formularzy;
//                 echo '<br>';
                //RADIOBUTTON
                $sql_insert = 'INSERT INTO odpowiedzi_studentow (`Studenci_idStudenci`, `Pytania_Z_Formularzy_idPytania_Z_Formularzy`, `Mozliwe_Odpowiedzi_idMozliwe_Odpowiedzi`)
                                VALUES('.$id.','.$id_pytania_z_formularzy.','.$value.')';
//                 echo '<br>';
//                 echo '$sql_insert = ' . $sql_insert;
//                 echo '<br>';
//                 echo '<br>';
                $insert_result = $conn->query($sql_insert);
                if (! $insert_result) {
                    trigger_error('Invalid query: ' . $conn->error);
                }
            }
        }
    }
    echo'<div style="display: block; padding-right:42%; margin-right: 3px;">
                <a class="btn btn-primary" style="color: white; float; right;"href="index.php" role="button"><i class="fa fa-home"></i> HOME</a>
            </div>';
    
    echo '<div class="defaultDiv defaultFont"><h3>Ankietę zapisano prawidłowo!</h3></div>';
    
                      //  <input type="hidden" id="type" name="type" value="' . $_POST["type"]. '">
                     //   <input type="hidden" id="user_id" name="user_id" value="' . $_POST["user_id"]. '">
    
    echo '<div class="row" style="width: 100%;">
    <div class="defaultDiv" style="width: 35%; text-align: center;">
        <form method="post" action="sugestie.php">
                    <div class="form-group">
                        <label style="" class="defaultFont" for="sugestia"><h4>Jesli masz jakies uwagi/pytania/sugestie napisz do nas!</h4></label>
                        <textarea name="sugestia" id"sugestia" class="form-control" rows="5"></textarea>
                    </div>
                        <input type="hidden" id="type" name="type" value="">
                        <input type="hidden" id="user_id" name="user_id" value="">
                        <br>
                        <input type="submit" class="btn btn-primary" style="width: 80%" value="Wyślij">
                        </form>
                        </div>';
   
    echo '<div class="defaultDiv defaultFont" style="width: 35%">
        <h4>Jesli chcesz wysłać CV załącz plik tutaj:</h4>';
    
    include 'cv_student.php';
    
    
    echo '</div>
    </div>';
    echo '</div></div>';
    include 'przycisk.php';
    echo'</body>
</html>';
    ?>