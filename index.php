
<!DOCTYPE html>
<?php
//język na pl
    echo'<html lang="pl">
         <head>';
    
//plik css i bootstrap do obsługi grafiki
    include 'header.php';
    
// rozpoczynam sesje w celu możliwosci korzystania ze zmiennych SESSION no i przede wszystkim wychwycenie osoby zalogowanej
       session_start();
       
//jesli istnieje zmienna sesyjna user_id(pracodawca albo studenet)
    if (isset($_SESSION['user_id'])) {

        include 'logout.php';
            
//jesli pracodawca idź do panel_pracodawca 
//jesli był zalogowany idź do panelu pracodawcy, jesli nie to ekran startowy 
        if($_SESSION['type'] == 'pracodawca') {
            header("Location: panel_pracodawca.php");
        }else{
            
            $_SESSION['zalogowany'] = false;
            session_destroy();
            $url = "index.php";
            header("Location: ".$url);
            exit();
        }
        
       
    
    } else {
        
        echo'<div>';

// przycisk home
        echo'<div style="display: block; padding-right:42%;">
                <a class="btn btn-primary" style="color: white; float; right;"href="index.php" role="button"><i class="fa fa-home"></i> HOME</a>
            </div>';
        
        echo'<div style="text-align:center; "id="header" class="defaultDiv">';
       
        
        echo'<div class="defaultFont" style=" border-bottom: solid 1px; width: 100%; display: inline-block;">
               <h3> Witaj!</h3>
            </div>';
       
        echo'<div class="defaultFont" style="display: inline-block;">
                Znajdujesz się na stronie internetowej, która ma na celu pomagać studentom w znalezieniu pierwszej pracy oraz pomagać pracodawcom w doborze strategii marketingowej zorientowanej na pozyskanie najlepszych studentów.
                </div>';
        
        echo'</div>';
         
        echo'<div id="central" class="defaultDiv" style="width: 30%; text-align: left;">';
        echo'<div style="margin-top:3%; display: block; text-align: center;" >';
        echo'<div class="defaultFont" style="display: block;">
               <h4> Kim jesteś?</h4>
             </div>';
        
//   Przesyłamy za pomocą POST type (student/pracodawca) label po co ?      
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
        include 'przycisk.php';
       
        
    }
    
    
    echo'</head>
<body>';
    ?>