<!DOCTYPE html>
<?php
echo'<html lang="pl">
<head>';
include 'header.php';
echo'<title>Logowanie studenta</title>';

//sprawdza poprawnosc indeksu 6 cyfr i same cyfry JAK TO DOKŁADNIE DZIAŁO
echo'<script type="text/javascript">
    	function sprawdz() {
        	var f = document.forms.formularzIndeks;
        	var index_error_text;
				if(isNaN(f.user_id.value) || f.user_id.value.length != 6 ){
					text = "Niepoprawny numer indeksu!";
					document.getElementById("index_error_message").innerHTML = text;
					return;
				}
				f.submit();	
    		}
    </script>'; 


echo'</head> 
<body>';

    include 'polaczenie_do_bazy.php';
   
    
    echo'<div id="container">';
    //tu będziemy przechowywać wszystko co ogólne
    echo'<div style="display: block; padding-right:42%;">
                <a class="btn btn-primary" style="color: white; float; right;"href="index.php" role="button"><i class="fa fa-home"></i> HOME</a>
            </div>';
    echo'<div style="text-align: center;" id="header" class="defaultDiv">';
    echo'<div class="defaultFont" style="display: inline-block; ">
               <h3> Studencie!</h3>
            </div></br>';
    
    echo'<div class="defaultFont" style="display: inline-block;">
              Dziękujemy za poswiecenie swojego cennego czasu. Wypełnij jedną z poniższych ankiet.
                </div>';
    
    echo'</div>';
    
    echo'<div id="central" class="defaultDiv" style="width: 30%;">';
        
//przeslij sql'a do bazy
    $sql_formularze = 'SELECT idFormularze, Nazwa FROM formularze';
    $result_formularze = $conn->query($sql_formularze);
 
//
    if (! empty($_POST["type"]) && $_POST["type"] == "student") {
        
        echo'<div style="margin-top:3%; display: block; text-align: center;" >';
        echo'<div class="defaultFont" style="display: inline-block;">
               <h4> Wpisz swój numer indeksu i wybierz ankietę.</h4>
                </div>';
        echo '<b id="index_error_message"  style=" display:block; font-size:20px; color: red; background-color: none;">
    	        </b>';
        
        
        
//przeslij do formularz student ominięcie entera..
        echo '<form method="post" action="formularz_student.php" name="formularzIndeks" onkeypress="return event.keyCode != 13;" 
        style="display: inline-block; margin-left: auto; margin-right: auto; text-align: center;">';
        echo '    	<label for="indeks" class="defaultFont" >Numer indeksu:</label>';
        echo'</br>';
        echo '    	<input class="form-control" placeholder="6-cyfrowy nr indeksu" id="user_id" maxlength="6" name="user_id" type="text" required>';
       
        echo '<z class="defaultFont" style="">Ankieta: </z>';
        echo'</br>';
        echo '      <select class="custom-select" id="formularz_id" name="formularz_id">';
                    
        
//wypisz wszyskite dostępne formularze (wykonuj dopóki cos zwraca) 
        while (     $row = $result_formularze->fetch_assoc()) { 
                    $id = $row['idFormularze'];
                    $nazwa = $row['Nazwa'];
            echo '<option value="' . $id . '">' . $nazwa . '</option>';
        }
        echo '      </select class="custom-select" ><br/>';
        echo '      <input type="hidden" id="type" name="type" value="' . $_POST["type"] . '">';
        echo '    	<input type="button" class="btn btn-primary" style="margin-top: 30px;" value="Zatwierdź" onclick="sprawdz()">';                    
        echo '</form>';
  
//jesli pracodawca
    } elseif (! empty($_POST["type"])) {
        $url = "logowanie_pracodawca.php";
        header("Location: " . $url);
        die();
    }
        else{
        $url = "index.php";
        header("Location: " . $url);
        die();
    }
    echo'</div>';
    echo'</div>';
 
    echo '</div></div>';
    include 'przycisk.php';
    echo'</head>
<body>';
    ?>