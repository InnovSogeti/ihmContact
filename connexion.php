<?php
if($_POST['groupe'] == "admin" || $_POST['groupe'] == "RH"){
    session_start();
    $_SESSION['groupe'] = $_POST['groupe'];
    $_SESSION['token'] = $_POST['token'];
    echo "Success";
} else {
    echo "Failed";
}
?>
