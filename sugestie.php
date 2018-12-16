<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
 </head>   
 <body>
    <?php
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
       
       //         echo '</div></div>';
       echo'<div id="footer"> <div class="row"><div style="padding:20px; margin-left:30%; margin-right:5%;">Strona internetowa została stworzona w ramach pracy inżynierskiej 2018!
            </div><b style="float:right; padding:20px;">Kontakt:</b><a style="  margin-right:auto;" href="www.facebook.pl/maciek.kubala.1" class="facebook fa fa-facebook"></a></div></div>';
       echo'</div>';
   } else{
         echo '
<a href="panel_pracodawca.php" class="btn btn-primary">Wróć do podsumowania</a>
         </div>';
     } 
    ?>
  <body>
  </html>