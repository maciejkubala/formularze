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
    

<script type="text/javascript">
    	function sprawdz() {
        	var f = document.forms.formularzIndeks;
        	var index_error_text;
				if(isNaN(f.user_id.value) || f.user_id.value.length != 6 ){
					text = 'Niepoprawny numer indeksu!';
					document.getElementById("index_error_message").innerHTML = text;
					return;
				}
				f.submit();	
    		}
    </script> 


</head> 
<body>

    <?php
   /*  include 'header.php'; */
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
    //pojemnik na przechowanie napisu wyboru i selecta
    
  
    $sql_formularze = 'SELECT idFormularze, Nazwa FROM formularze';
    $result_formularze = $conn->query($sql_formularze);
    
    if (! empty($_POST["type"]) && $_POST["type"] == "student") {
        
        echo'<div style="margin-top:3%; display: block; text-align: center;" >';
        echo'<div class="defaultFont" style="display: inline-block;">
               <h4> Wpisz swój numer indeksu i wybierz ankietę.</h4>
                </div>';
      
        echo '<form method="post" action="formularz_student.php" name="formularzIndeks" onkeypress="return event.keyCode != 13;" 
        style="display: inline-block; margin-left: auto; margin-right: auto; text-align: center;">';
        echo '    	<label for="indeks" class="defaultFont" >Numer indeksu:</label>';
        echo'</br>';
        echo '    	<input class="form-control" placeholder="6-cyfrowy nr indeksu" id="user_id" maxlength="6" name="user_id" type="text" required>';
       
        echo '<z class="defaultFont" style="">Ankieta: </z>';
        echo'</br>';
        echo '      <select class="custom-select" id="formularz_id" name="formularz_id">';
        while (     $row = $result_formularze->fetch_assoc()) { 
                    $id = $row['idFormularze'];
                    $nazwa = $row['Nazwa'];
            echo '<option value="' . $id . '">' . $nazwa . '</option>';
        }
        echo '      </select class="custom-select" ><br/>';
        echo '      <input type="hidden" id="type" name="type" value="' . $_POST["type"] . '">';
        echo '    	<input type="button" class="btn btn-primary" style="margin-top: 30px;c" value="Zatwierdź" onclick="sprawdz()">';                    
        echo '</form>';
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
    echo'<div id="footer"> <div class="row"><div style="padding:20px; margin-left:30%; margin-right:5%;">Strona internetowa została stworzona w ramach pracy inżynierskiej 2018!
            </div><b style="float:right; padding:20px;">Kontakt:</b><a style="  margin-right:auto;" href="www.facebook.pl/maciek.kubala.1" class="facebook fa fa-facebook"></a></div></div>';
    echo'</div>';
    
    ?>	
</body>
</html>