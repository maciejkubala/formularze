<!doctype html>
<html lang="pl">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" type="text/css" href="style.css.php">
</head>
<body>
    
    <?php
    session_start();

    include 'logout.php';
    include 'header.php';
    include 'polaczenie_do_bazy.php';

    if (! empty($_POST)) {


        if (! empty($_POST['konkurs_id'])) {
            $konkurs_id = $_POST['konkurs_id'];
        }
        
        //NAZWA FORMULARZA MAKS PUNKTOW 
        $select_nazwa_konkursu= 'SELECT Nazwa, maks_punktow
                                     FROM konkursy_pracodawcow
                                    WHERE idKonkursy_Pracodawcow= ' . $konkurs_id;
        
        $result_nazwa_konkursu = $conn->query($select_nazwa_konkursu);
        
       
        $row = mysqli_fetch_assoc($result_nazwa_konkursu);
        $maks_punktow = $row['maks_punktow'];
        $nazwa_konkursu = $row['Nazwa'];
        
      
            
        // lita studentow
        
        $ilosc = $_POST['ilosc_osob'];
        
        $select_lista_studentow = 'SELECT Nr_Indeksu, konkurs_id, punkty_rekrutacyjne
                                     FROM v_lista_studentow
                                    WHERE konkurs_id = ' . $konkurs_id . '
                                    ORDER BY punkty_rekrutacyjne DESC
                                    LIMIT ' . $ilosc;
        // wykonac sql
        $result_lista_studentow = $conn->query($select_lista_studentow);
        // jesli sql cos zwrocil
        
        //oblicz wage maksymalna
       /*  $sql_maks_punktow = 'select oblicz_maks_punktow(' . $konkurs_id . ') as maks_punktow';
        $sql_maks_punktow_result = $conn->query($sql_maks_punktow);
        $row = mysqli_fetch_assoc($sql_maks_punktow_result);
        $maks_punktow = $row['maks_punktow']; */
        
        echo'<h3>WYBRANY FORMULARZ: "'.$nazwa_konkursu.'"</h3>';
        
        
        echo '<table style="width:50%">
              <tr>
              <td>
               Maksymalna liczba punktów do zdobycia: '. $maks_punktow . ' -100%<br>
              </td>
              </tr>
        
              </table>';
        
        
        
        /* echo 'Maksymalna liczba punktów do zdobycia: '. $maks_punktow . ' -100%<br>';
        echo 'TABELA NAJLEPSZYCH STUDENTÓW
                <br/>
                <br/>'; */
        
        if ($result_lista_studentow->num_rows > 0) {
            $nr = 1;
          echo '
                <table style="width:50%">
                <tr">
                <th>MIEJSCE</th>
                <th>Numer indeksu</th> 
                <th>Wynik punktowy [pkt]</th>
                <th>Wynik procentowy [%]</th> 
                </tr>';
           
            while ($row = $result_lista_studentow->fetch_assoc()) {
                
                $nr_indeksu = $row["Nr_Indeksu"];
                $wynik = $row["punkty_rekrutacyjne"];
                $wynik_procentowy= round(($wynik/$maks_punktow)*100,2);
                
            
                echo '<tr>';
                
                echo '<td>';
                echo '' . $nr . '.';
                echo '</td>';
                
                echo '<td>';
                echo $nr_indeksu;
                echo '</td>';
                
                echo '<td>';
                echo $wynik;
                echo '</td>';
                
                echo '<td>';
                echo $wynik_procentowy;
                echo '</td>';
             
                echo '</tr>';
            
                $nr++;
            }
         echo '</table>';
        }
    } else {}
    // przycisk powrotu do index.php
    
        
    echo ('<a href="panel_pracodawca.php" class="option-input" style="width: 150px; text-decoration: none;">Wroc do panelu pracodawcy</a><br/><br/><br/>');
    ?>

    <!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>