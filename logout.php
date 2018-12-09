<?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $_POST['user_id'] = $user_id;
    
} else {
    $_SESSION['zalogowany'] = false;
    session_destroy();
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['type'])) {
    $type = $_SESSION['type'];
    $_POST['type'] = $type;
    
} else {
    $_SESSION['zalogowany'] = false;
    session_destroy();
    header('Location: index.php');
    exit;
}

if(isset($user_id)) {
    
    if($type == "pracodawca"){
//         Echo $user_id;
//         echo'blabal';
        echo '<div class="right"><a href="?wyloguj=1">Wyloguj</a></div>';
    }else {
//     echo $user_id;
    echo '<div class="right" style="color:black; ">Kliknij, aby wyjsc do strony głównej:</br></br><a href="?wyloguj=1" style="color:red;" >'.$user_id.'</a></div>';
    // if user type  = student to w wtedy wyswietli link z numerem indeksu a w przeciwnym wypadku tak jak bylo
     
    }
    
    
    
    if (isset($_GET['wyloguj'])==1)
    {
        $_SESSION['zalogowany'] = false;
        session_destroy();
        $url = "index.php";
        header("Location: ".$url);
        die();
        
    }
}
?>