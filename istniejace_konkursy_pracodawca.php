
<!DOCTYPE html>
<?php
echo'<html lang="pl">
<head>';
include 'header.php';

    session_start();

    include 'logout.php';
  //  include 'header.php';
    include 'polaczenie_do_bazy.php';
    echo'<div style="display: block; padding-right:42%;">
                <a class="btn btn-primary" style="color: white; float; right;"href="panel_pracodawca.php" role="button"><i class="fa fa-home"></i>PANEL PRACODAWCY</a>
            </div>';
    
    if (! empty($_POST)) {


        if (! empty($_POST['konkurs_id'])) {
            $konkurs_id = $_POST['konkurs_id'];
        }
        
        //NAZWA FORMULARZA MAKS PUNKTOW 
        $select_nazwa_konkursu= 'SELECT Nazwa, maks_punktow, Opis_Stanowiska
                                     FROM konkursy_pracodawcow
                                    WHERE idKonkursy_Pracodawcow= ' . $konkurs_id;
        
        $result_nazwa_konkursu = $conn->query($select_nazwa_konkursu);
        
       
        $row = mysqli_fetch_assoc($result_nazwa_konkursu);
        $maks_punktow = $row['maks_punktow'];
        $nazwa_konkursu = $row['Nazwa'];
        $opis_stanowiska =$row["Opis_Stanowiska"];
     
        
        // lita studentow
        $ilosc = $_POST['ilosc_osob'];
        
        $select_lista_studentow = 'SELECT Nr_Indeksu, konkurs_id, punkty_rekrutacyjne, Plik_Do_CV
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
        

        
         $select_opis_stanowiska = 'SELECT Opis_Stanowiska
                                     FROM konkursy_pracodawcow
                                    WHERE idKonkursy_Pracodawcow = ' . $konkurs_id . '';
                                    
        $result_opis_stanowiska = $conn->query($select_opis_stanowiska);
        
         
        
        echo'<div class="defaultDiv defaultFont row" style="clear:both; width: 80%; margin-left: auto; margin-right: auto;">
        <h3 style="width: 35%; border-right: solid 1px;">WYBRANY KONKURS:<br/> "'.$nazwa_konkursu.'"</h3>'; 
        echo '<h4 style="width: 60%; text-align: left; margin-left: 5%;">Opis konkursu: '. $opis_stanowiska.'</h4>
        <div style="text-align: center; border-top: solid 1px; width: 100%;">Maksymalna liczba punktów do zdobycia: <b>'. $maks_punktow . '</b> pkt.</div>
        </div>';
        
        if ($result_lista_studentow->num_rows > 0) {
            $nr = 1;
          echo '<div class="defaultDiv defaultFont">
                <table class="table table-striped">
                <thead>
                <tr">
                <th scope="col">MIEJSCE</th>
                <th scope="col">Numer indeksu</th> 
                <th scope="col">Wynik punktowy [pkt]</th>
                <th scope="col">Wynik procentowy [%]</th> 
                <th scope="col">CV studenta</th> 
                </tr>
                </thead>
                <tbody>';
           
            while ($row = $result_lista_studentow->fetch_assoc()) {
                
                $nr_indeksu = $row["Nr_Indeksu"];
                $wynik = $row["punkty_rekrutacyjne"];
                $wynik_procentowy= round(($wynik/$maks_punktow)*100,2);
                $cv = $row["Plik_Do_CV"];
            
                echo '<tr>';
                
                echo '<th scope="row">';
                echo '' . $nr . '.'; //
                echo '</th>';
                
                echo '<td>';
                echo $nr_indeksu; 
                echo '</td>';
                
                echo '<td>';
                echo $wynik;
                echo '</td>';
                
                echo '<td>';
                echo $wynik_procentowy;
                echo '</td>';

                echo '<td>';
                echo '<a target="_blank" rel="noopener noreferrer"style="color:black;" href='.$cv. '>'.$cv.'</a>';//
                echo '</td>';
                
                echo '</tr>';
            
                $nr++;
            }
         echo '</tbody>
         </table>
         </div>';
        }
    } else {}
    
    echo'<div id="footer">
            <a href=""
        tu będą informacje/ kontakt do autora oraz że strona została zrobiona w ramach pracy inżynierskiej 2018 PWr!';
    
    echo'</div>';
    
    echo'</head>
<body>';
    ?>