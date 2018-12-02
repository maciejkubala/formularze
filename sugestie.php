<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    
	<link rel="stylesheet" type="text/css" href="style.css.php">
    
    <?php
    include 'polaczenie_do_bazy.php';
    include 'logout.php';
    include 'header.php';
          
        $sugestia = $_POST["sugestia"];
    if (isset($sugestia)){
        $sql_insert_sugestia = 'INSERT INTO `sugestie` (`id_sugestii`, `tresc`,`data`,`status`)
                            VALUES(NULL,"'.$sugestia.'",NOW(),"NEW")';
        $insert_result_sugestia = $conn->query($sql_insert_sugestia);   
        
        if (! $insert_result_sugestia) {
            trigger_error('Invalid query: ' . $conn->error);
        }
        
   echo '<h3>Twoja sugestia została zapisana!!</h3><br> Dziękujemy!<br>';
    
    }
    if(isset($_POST['type']) && $_POST['type'] == "student") {
        echo '<form method="post" action="zapisz_ankiete_student.php">
                        <input type="hidden" id="type" name="type" value="' . $_POST["type"]. '">
                        <input type="hidden" id="user_id" name="user_id" value="' . $_POST["user_id"]. '">
                        <input type="submit" class="option-input" style="width: 100px;" value="Wróć">
              </form>';
        
//          echo('<a href="zapisz_ankiete.php" class="option-input" style="width: 150px; text-decoration: none;">Wroc na poczatek</a>');
    } else{
         echo('<a href="panel_pracodawca.php" class="option-input" style="width: 150px; text-decoration: none;">Wroc do panelu pracodawcy</a>');
     } 
    ?>
    
  </head>
  <body>
  </html>