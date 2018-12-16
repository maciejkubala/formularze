<!DOCTYPE html>
<html>
<head>
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

include 'logout.php';
echo'<div style="display: block; padding-right:42%;">
                <a class="btn btn-primary" style="color: white; float; right;"href="panel_pracodawca.php" role="button"><i class="fa fa-home"></i> PANEL PRACODAWCY</a>
            </div>';
include 'polaczenie_do_bazy.php';

if (! empty($_POST['konkurs_id'])) {

    $konkurs_id = $_POST['konkurs_id'];
    
    $delete_wagi_pyt='DELETE FROM wagi_odpowiedzi
	WHERE
	Konkursy_Pracodawcow_idKonkursy_Pracodawcow ='. $konkurs_id;

    $delete_wagi_odp='DELETE FROM wagi_pytan 
	WHERE
	Konkursy_Pracodawcow_idKonkursy_Pracodawcow='. $konkurs_id;

    
    $delete_konkurs= 'DELETE FROM konkursy_pracodawcow
                      WHERE idKonkursy_Pracodawcow = '. $konkurs_id;
    
    $conn->query($delete_wagi_pyt);
    
    if (! $delete_wagi_pyt) {
        trigger_error('Invalid query: ' . $conn->error);
    }
    
    $conn->query($delete_wagi_odp);
    
    
    if (! $delete_wagi_odp) {
        trigger_error('Invalid query: ' . $conn->error);
    }
    
   $conn->query($delete_konkurs);

   
   if (! $delete_konkurs) {
       trigger_error('Invalid query: ' . $conn->error);
   }
}


//$result_delete_konkurs = $conn->query($delete_konkurs);

echo '<div style="clear:both; font-weight: 500;"class="defaultDiv defaultFont">
Konkurs został usunięty!</br>
<a href="panel_pracodawca.php" style="margin-top:10px;" class="btn btn-primary">Wroc do panelu pracodawcy</a>
</div>';


?>
</body>
</html>
