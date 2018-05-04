<?php
if($_POST['groupe'] == "admin" || $_POST['groupe'] == "RH"){
    session_start();
    $_SESSION['groupe'] = $_POST['groupe'];
    echo "Success";
} else {
    echo "Failed";
}
?>
