<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    
	<link rel="stylesheet" type="text/css" href="style.css.php">
    
<!-- Krótka wzmianka o cv do pracodawcy-->
  </head>
  <body> 
  
  <form action="#file" method='post' enctype="multipart/form-data">
  <!--<input type="text" name="Opis_Pliku"/><br><br>-->
  <input type="file" name="Plik_Do_CV"/><br><br>	
  <input type="submit" name="submit" value="Upload"/>
  </form> 
  
    <?PHP
    session_start();
    INCLUDE 'POLACZENIE_DO_BAZY.PHP';
    INCLUDE 'LOGOUT.PHP';
    INCLUDE 'HEADER.PHP'; 
    
    
   //1 BLOCK
    $NAME= $_FILES['Plik_Do_CV']['name'];
    
    $TMP_NAME= $_FILES['Plik_Do_CV']['tmp_name'];
    
    $SUBMITBUTTON= $_POST['submit'];
        
    $POSITION= STRPOS($NAME, ".");
    
    $FILEEXTENSION= SUBSTR($NAME, $POSITION + 1);
    
    $FILEEXTENSION= STRTOLOWER($FILEEXTENSION);
    
    //$DESCRIPTION= $_POST['Opis_Pliku'];
    
    
    
    IF (ISSET($NAME)) {
        
        $PATH= 'pliki/';
        
        IF (!EMPTY($NAME)){
            IF (MOVE_UPLOADED_FILE($TMP_NAME, $PATH.$NAME)) {
              
                $select_update = 'UPDATE studenci
	SET
	Plik_Do_CV = "'.$NAME.'"
	WHERE
	idStudenci = '.$_SESSION['student'].'';
                
                
                //  echo $select_update;
                $RESULT= $conn->query($select_update);
                
                
                if (! $RESULT) {
                    trigger_error('Invalid query: ' . $conn->error);
                }
                
                DIE();
                ECHO 'Plik został pobrany prawidłowo!';
            }
        }
    }
    //2 BLOCK
   /*  IF(!EMPTY($DESCRIPTION)){
        $insert = $conn->QUERY("INSERT INTO STUDENCI (Plik_Do_CV)
		VALUES ('.$NAME.')"); 
    } */
    
    //3 BLOCK
    
  
   /*  $RESULT= $conn->QUERY("INSERT INTO STUDENCI (idStudenci, Nr_Indeksu, Data_Wypelnienia, Plik_Do_CV, Opis_Pliku)
		VALUES (32, 201811, NOW(), ' .$NAME.','.$DESCRIPTION.')"); 
    
    
    if (! $RESULT) {
        trigger_error('Invalid query: ' . $conn->error);
    }
    
         DIE(); */
    // OR DIE("SELECT ERROR: ".MYSQLI_ERROR());
    // dla kazdego wiersza zwrĂłconego
        /*  while ($row = $resultOdpowiedziDoPytania->fetch_assoc()) {
             // z wiersza pobieramy wartosci
             $tresc = $row["Tresc"];
             $idMozliwe_Odpowiedzi = $row["idMozliwe_Odpowiedzi"];
         */
        
/*     PRINT "<TABLE BORDER=1>\N";
    WHILE ($ROW = $RESULT->fetch_assoc()){
        $FILES_FIELD= $ROW['Plik_Do_CV'];
        $FILES_SHOW= "pliki/$FILES_FIELD";
     //$DESCRIPTIONVALUE= $ROW['Opis_Pliku'];
        PRINT "<TR>\N";
        //PRINT "\T<TD>\N";
        //ECHO "<FONT FACE=ARIAL SIZE=4/>$DESCRIPTIONVALUE</FONT>";
       // PRINT "</TD>\N";
        PRINT "\T<TD>\N";
        ECHO "<DIV ALIGN=CENTER><A HREF='$FILES_SHOW'>$FILES_FIELD</A></DIV>";
        PRINT "</TD>\N";
        PRINT "</TR>\N";
    }
    PRINT "</TABLE>\N";  */
    
    echo ('<a href="zapisz_ankiete.php" class="option-input" style="width: 150px; text-decoration: none;">Dopisz sugestie</a><br/><br/><br/>');
    ?>
  
  </body>
  </html>