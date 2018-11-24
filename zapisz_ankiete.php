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
//         echo("Student: ".$id."<br/>");
            //zapisz odpowiedzi studenta z ankiety
            foreach($_POST as $key => $value) { 
//                 echo("key: ".$key." value: ".$value."<br/>");
//JEST TABLICA RADIONVS CHECKBOX
                if(is_array($value)){
                    foreach($value as $odpowiedz){
                        $sql_insert = 'INSERT INTO odpowiedzi_studentow (`Studenci_idStudenci`, `Pytania_Z_Formularzy_idPytania_Z_Formularzy`, `Mozliwe_Odpowiedzi_idMozliwe_Odpowiedzi`)
                            VALUES('.$id.','.$key.','.$odpowiedz.')';
                        $insert_result = $conn->query($sql_insert);
                    }
                 
                }else{
                    //RADIOBUTTON
                $sql_insert = 'INSERT INTO odpowiedzi_studentow (`Studenci_idStudenci`, `Pytania_Z_Formularzy_idPytania_Z_Formularzy`, `Mozliwe_Odpowiedzi_idMozliwe_Odpowiedzi`)
                            VALUES('.$id.','.$key.','.$value.')';
                $insert_result = $conn->query($sql_insert);
            }
            }
                  
          
           
               
            
            
            
           /*  $sugestia = $_POST["sugestia"];
            if (isset($_POST['sugestia'])){ 
                            $sql_insert_sugestia = 'INSERT INTO `sugestie` (`id_sugestii`, `tresc`)
                            VALUES(NULL,'.$sugestia.')';
                            $insert_result_sugestia = $conn->query($sql_insert_sugestia); */
                        }
                        
                    echo $_POST['type'];
                    echo ("<h2>Ankietę zapisano prawidłowo!<br/></h2>");
                    //przycisk do powrotu do index.php
                    echo '<form method="post" action="sugestie.php">
                        <label for="sugestia">Jesli masz jakies uwagi/pytania/sugestie napisz do nas!</label>
                        <textarea name="sugestia" id"sugestia" rows="5" cols="40"></textarea>
                        <input type="hidden" id="type" name="type" value="' . $_POST["type"]. '">
                        <input type="submit" class="option-input" style="width: 100px;" value="Wyslij">
                        </form>';
                  
            
            
            echo('<a href="index.php" class="option-input" style="width: 150px; text-decoration: none;">Wroc na poczatek</a>');
        

    
    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>