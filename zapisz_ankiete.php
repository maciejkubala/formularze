<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="style.css.php">
    <title>Sugestie</title>
  </head>
  <body>
    
    
    <?php 
    session_start();
    
    include 'header.php';
    include 'polaczenie_do_bazy.php';
    //-------------------------------
/*     // POLACZENIE DO BAZY
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "baza_formularzy";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8"); */
    
    //znajdz id studenta o numerze inkdeksu z session
    // zapytanie o odpowiedzi do pytania -> patrz parameter idPytania
    $sqlIdStudenta = "SELECT idStudenci FROM studenci WHERE Nr_Indeksu = ".$_SESSION['student'];
    
    // wykonac sql
    $resultIdStudenta = $conn->query($sqlIdStudenta);
    
    if ($resultIdStudenta->num_rows > 0) {
        // dla kazdego wiersza zwr�conego
        while ($row = $resultIdStudenta->fetch_assoc()) {
            
            $id=$row["idStudenci"];
            
        }
    }

    if(empty($id)){
        
        $select_id_student ='INSERT INTO `studenci` (`Nr_Indeksu`, `Data_Wypelnienia`) VALUES ('.$_SESSION['student'].', NOW());';
        $resultInsertStudent = $conn->query($select_id_student);
        //$id = $conn->insert_id;
        
        $sqlIdStudenta = "SELECT idStudenci FROM studenci WHERE Nr_Indeksu = ".$_SESSION['student'];
        
        $resultIdStudenta = $conn->query($sqlIdStudenta);
        
        if ($resultIdStudenta->num_rows > 0) {
            // dla kazdego wiersza zwr�conego
            while ($row = $resultIdStudenta->fetch_assoc()) {
                
                $id=$row["idStudenci"];
                
            }
        }
    }
    
    if(!empty($_POST)) {
            //echo("Student: ".$id."<br/>");
            //zapisz odpowiedzi studenta z ankiety
            foreach($_POST as $key => $value) { 
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo("key: ".$key." value: ".$value."<br/>");
                echo 'substr($key, 0, 4)' . substr($key, 0, 4);
                
                if((substr($key, 0, 4) == "inne") && is_array($value)) {
                    // pomiń checkbox z pytania inne
                    // pytanie inne bedzie zapisane z textboxa
                }
                elseif(substr($key, 0, 4) == "inne") {
                    echo '<br>';
                    echo 'inne';
                    //INNE
                    $id_pytania = substr($key, 4, strpos($key, 'o') - 4);
                    echo 'id_pytania = ' . $id_pytania;
                    echo '<br>';
                    $id_odpowiedzi = substr($key, strpos($key, 'o') + 3, strlen($key) - (strpos($key, 'o') + 3));
                    echo 'id_odpowiedzi = ' . $id_odpowiedzi;
                    $sql_insert = 'INSERT INTO odpowiedzi_studentow (`Studenci_idStudenci`, `Pytania_Z_Formularzy_idPytania_Z_Formularzy`, `Mozliwe_Odpowiedzi_idMozliwe_Odpowiedzi`, `Odpowiedz_tekstowa`)
                                VALUES('.$id.','.$id_pytania.', ' . $id_odpowiedzi . ', "'.$value.'")';
                    echo '<br>';
                    echo $sql_insert;
                    $insert_result = $conn->query($sql_insert);
                    if (! $insert_result) {
                        trigger_error('Invalid query: ' . $conn->error);
                    }
                    
                }
                elseif (is_array($value)){
                    echo '<br>';
                    echo 'checkbox';
                    //CHECKBOXY
                    foreach($value as $odpowiedz){
                        $sql_insert = 'INSERT INTO odpowiedzi_studentow (`Studenci_idStudenci`, `Pytania_Z_Formularzy_idPytania_Z_Formularzy`, `Mozliwe_Odpowiedzi_idMozliwe_Odpowiedzi`)
                            VALUES('.$id.','.$key.','.$odpowiedz.')';
                        $insert_result = $conn->query($sql_insert);
                        if (! $insert_result) {
                            trigger_error('Invalid query: ' . $conn->error);
                        }
                    }
                }
                elseif (is_numeric($value)){
                    echo '<br>';
                    echo 'radio';
                    //RADIOBUTTON
                    $sql_insert = 'INSERT INTO odpowiedzi_studentow (`Studenci_idStudenci`, `Pytania_Z_Formularzy_idPytania_Z_Formularzy`, `Mozliwe_Odpowiedzi_idMozliwe_Odpowiedzi`)
                                VALUES('.$id.','.$key.','.$value.')';
                    $insert_result = $conn->query($sql_insert);
                    if (! $insert_result) {
                        trigger_error('Invalid query: ' . $conn->error);
                    }
                }
            }
                  
          
                    echo ("<h2>Ankietę zapisano prawidłowo!<br/></h2>");
                    //przycisk do powrotu do index.php
                    echo '<form method="post" action="sugestie.php">
                        <label for="sugestia">Jesli masz jakies uwagi/pytania/sugestie napisz do nas!</label>
                        <textarea name="sugestia" id"sugestia" rows="5" cols="40"></textarea>
                        <input type="hidden" id="type" name="type" value="' . $_POST["type"]. '">
                        <input type="submit" class="option-input" style="width: 100px;" value="Wyslij">
                        </form>';
                  
            
            
            echo('<a href="index.php" class="option-input" style="width: 150px; text-decoration: none;">Wroc na poczatek</a>');
        

    }
    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>