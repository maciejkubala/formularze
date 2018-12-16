<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- <meta http-equiv="refresh" content="10" > -->
    
	<link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
  </head> 	
 <body>
    <?php 
   
    /*include 'polaczenie_do_bazy.php';*/
    session_start();
    
    
    if (isset($_SESSION['user_id'])) {
        
        include 'logout.php';
        if($_SESSION['type'] == 'pracodawca') {
            header("Location: panel_pracodawca.php");
        }else{
            
            $_SESSION['zalogowany'] = false;
            session_destroy();
            $url = "index.php";
            header("Location: ".$url);
            die();
        }
        
       
    
    } else {
        
        echo'<div>';
        //tu będziemy przechowywać wszystko co ogólne
        echo'<div style="display: block; padding-right:42%;">
                <a class="btn btn-primary" style="color: white; float; right;"href="index.php" role="button"><i class="fa fa-home"></i> HOME</a>
            </div>';
        
        echo'<div style="text-align:center; "id="header" class="defaultDiv">';
       
        
        echo'<div class="defaultFont" style="display: inline-block;">
               <h3> Witaj!</h3>
            </div>';
       
        echo'<div class="defaultFont" style="display: inline-block;">
                Znajdujesz się na stronie internetowej stworzonej, która ma na celu pomagać studentom w znalezieniu pierwszej pracy oraz pomagać pracodawcom w doborze strategii marketingowej dotyczącej pierwszej pracy.
                </div>';
        
        echo'</div>';
         
        echo'<div id="central" class="defaultDiv" style="width: 30%; text-align: left;">';
        //pojemnik na przechowanie napisu wyboru i selecta
        
        echo'<div style="margin-top:3%; display: block; text-align: center;" >';
        echo'<div class="defaultFont" style="display: block;">
               <h4> Kim jesteś?</h4>
                </div>';
        
        echo '<form method="post" action="login_student.php" style="display: inline-block; margin-left: auto; margin-right: auto; text-align: center; width: 50%;">
              <label for="type" class="defaultFont"></label>

              </br>
              <select name="type" class="custom-select" id="type">
              <option disabled selected>Wybierz opcję</option>
              <option value="student">Student</option>
              <option value="pracodawca">Pracodawca</option>
              </select><br/>
              <input type="submit" class="btn btn-primary" style="margin-top: 30px;" value="Zatwierdź">
              </form>';
        
        echo'</div>';
     
        echo'</div>';
        
        echo '</div></div>';
        echo'<div id="footer"> <div class="row"><div style="padding:20px; margin-left:30%; margin-right:5%;">Strona internetowa została stworzona w ramach pracy inżynierskiej 2018!
            </div><b style="float:right; padding:20px;">Kontakt:</b><a style="  margin-right:auto;" href="www.facebook.pl/maciek.kubala.1" class="facebook fa fa-facebook"></a></div></div>';
        echo'</div>';
    }
    
    ?>
    
  </body>
</html>