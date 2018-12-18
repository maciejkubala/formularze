<!DOCTYPE html>
<?php
echo'<html lang="pl">
<head>';
include 'header.php';
echo'</head>
<body>';

    session_start();
    include 'polaczenie_do_bazy.php';
   include 'logout.php';
   // include 'header.php';
          
        $sugestia = $_POST["sugestia"];
    if (isset($sugestia)){
        $sql_insert_sugestia = 'INSERT INTO `sugestie` (`id_sugestii`, `tresc`,`data`,`status`)
                            VALUES(NULL,"'.$sugestia.'",NOW(),"NEW")';
        $insert_result_sugestia = $conn->query($sql_insert_sugestia);   
        
        if (! $insert_result_sugestia) {
            trigger_error('Invalid query: ' . $conn->error);
        }
        
        echo'<div style="display: block; padding-right:42%; margin-right: 3px;">
                <a class="btn btn-primary" style="color: white; float; right;"href="index.php" role="button"><i class="fa fa-home"></i> HOME</a>
            </div>';
        
   echo '<div class="defaultDiv defaultFont"><h4>Twoja sugestia została zapisana. Dziękujemy!</h4></br>';
    
    }
   if(isset($_POST['type']) && $_POST['type'] == "student") {
        /* echo '<div class="defaultDiv defaultFont" style="width:50%;"> */
       echo' <form method="post" action="zapisz_ankiete_student.php">
                        <input type="hidden" id="type" name="type" value="' . $_POST["type"]. '">
                        <input type="hidden" id="user_id" name="user_id" value="' . $_POST["user_id"]. '">
                        <input type="submit" class="btn btn-primary" style="width: 100px;" value="Wróć">
              </form>
              </div>';
       
       include 'przycisk.php';
   } else{
         echo '
<a href="panel_pracodawca.php" class="btn btn-primary">Wróć do podsumowania</a>

         </div>';
     } 
     echo'</head>
<body>';
     ?>