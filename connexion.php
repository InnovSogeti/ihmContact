<?php


    if( isset($_POST['groupe'])){

        if($_POST['groupe'] == "admin" || $_POST['groupe'] == "RH"){
            session_start();
            $_SESSION['groupe'] = $_POST['groupe'];
            echo "Success";
        }
        else{ // Sinon
            echo $_POST['groupe'];
        }
    }
?>
