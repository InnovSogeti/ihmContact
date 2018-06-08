<script>
function eraseCookie(name) {
	createCookie(name,"",-1);
}
$(document).ready(function () {
    eraseCookie("token");
})
</script>
<?php 
    session_start();
    session_destroy();
    header("location: ./authentification.php");
    exit;
?>
