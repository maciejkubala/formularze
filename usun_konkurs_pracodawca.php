<!DOCTYPE html>
<?php
echo'<html lang="pl">
<head>';
include 'header.php';
echo'</head>
<body>';

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

include 'przycisk.php';
echo'</head>
<body>';
?>