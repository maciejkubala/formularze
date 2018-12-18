
<?php
//przypisuje wartosci do zmiennych $user_id, $type, zabezpieczenie przed dostępem do stron bez logowania

//jesli istnieje cos pod zmienna sesyjna to zrob z niej
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $_POST['user_id'] = $user_id;
    
//jesli nie istnieje to zakończ sesję i idź do początku     
} else {
    $_SESSION['zalogowany'] = false;
    session_destroy();
    header('Location: index.php');
    exit;
}
//jesli istnieje informacja o tym kim jestes 
if (isset($_SESSION['type'])) {
    $type = $_SESSION['type'];
    $_POST['type'] = $type;
    
} else {
    $_SESSION['zalogowany'] = false;
    session_destroy();
    header('Location: index.php');
    exit;
}


//jesli juz wpisalismy numer indeksu albo jesli juz 
if(isset($user_id)) {
    
    if($type == "pracodawca"){

// stwórz przycisk wyloguj dla pracodawcy 
        echo '<div class="btn btn-primary" style="top:0px; right:0px; float:left; margin-right: 4px;"><a class="defaultFont" style="color:white; font-size:14px;" href="?wyloguj=1">Wyloguj</a></div>';
    }else {
        
// stwórz przycisk pokazujący studentowi swój numer indeksu      
    echo '<div class="btn btn-primary" style="top:0px; right:0px; float:left; margin-right: 4px;">Student:<i class="defaultFont" style="color:white; font-size:14px;">'.$user_id.'</i></div>';
    }
// przycisk dla studenta nie ma na celu wylogowywania go więc nie wchodzi do tej pętli     
    if (isset($_GET['wyloguj'])==1)
    {
        $_SESSION['zalogowany'] = false;
        session_destroy();
        $url = "index.php";
        header("Location: ".$url);        
        exit;
        
    }
}
?>