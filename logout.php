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

if(isset($_POST['user_id'])) {
    
     echo '<div class="right"><a href="?wyloguj=1">Wyloguj</a></div>';
//    echo '<a href="?wyloguj=1">[Wyloguj]</a>';
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