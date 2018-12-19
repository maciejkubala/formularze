    <?php
  
    echo ' <br>';
    echo ' <br>';
    echo ' <form action="zapisz_ankiete_student.php" method=\'post\' enctype="multipart/form-data">';
    echo ' <input type="file" class="file" name="Plik_Do_CV" style="width:80%; margin-top: 23px;" />';    
    echo ' <input type="hidden" id="type" name="type" value="' . $_POST["type"] . '">';
    echo ' <input type="hidden" id="user_id" name="user_id" value="' . $_POST["user_id"] . '">';
    echo'</br></br></br>'; 
    echo ' <input type="submit" style="width: 80%" class="btn btn-primary" name="submit" value="Wyślij"/>';
    echo ' </form>';

    // 1 BLOCK

    if (isset($_FILES['Plik_Do_CV'])) {
        $NAME = $_FILES['Plik_Do_CV']['name'];

        $TMP_NAME = $_FILES['Plik_Do_CV']['tmp_name'];

        $POSITION = STRPOS($NAME, ".");

        $FILEEXTENSION = SUBSTR($NAME, $POSITION + 1);
//rozszerzenie na lowercase 
        $FILEEXTENSION = STRTOLOWER($FILEEXTENSION);


        IF (isset($NAME)) {

            $path = 'pliki/';

            $newFileName = $path . $_SESSION['user_id'] . '_' . $NAME;
            IF (! EMPTY($NAME)) {
                IF (MOVE_UPLOADED_FILE($TMP_NAME, $newFileName)) {

                    $sql_update = 'UPDATE studenci
                            	  SET Plik_Do_CV = "' . $newFileName . '"
                            	WHERE Nr_indeksu = ' . $_SESSION['user_id'] . '';

                    // echo '$sql_update = ' . $sql_update;
                    // echo $select_update;
                    $result_update = $conn->query($sql_update);

                    if (! $result_update) {
                        trigger_error('Invalid query: ' . $conn->error);
                    }

                    
                    echo'Plik został pobrany prawidłowo!';
                }
            }
        }
    }
    ?>
