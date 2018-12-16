<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baza_formularzy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
/* echo'<link rel="stylesheet" type="text/css" href="style.css">';
echo'<form method="post" action="index.php">
<button class="btn" ><i class="fa fa-home"></i> Home</button>
</form>'; */
?>