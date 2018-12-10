<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
session_start();

include 'logout.php';
include 'header.php';
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


echo 'Konkurs '. $_POST['konkurs_id']. ' został usunięty!';
echo '<br/>';
echo ('<a href="panel_pracodawca.php" class="option-input" style="width: 150px; text-decoration: none;">Wroc do panelu pracodawcy</a><br/><br/><br/>');


?>
</body>
</html>
