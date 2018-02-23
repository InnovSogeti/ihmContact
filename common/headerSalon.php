<?php 
    include('common/header.php'); 
    if(isset($_GET['id_salon'])){
        $_SESSION['id_salon']=$_GET['id_salon'];
    }
?>
<body>
    <script>
        $(function() {
            $.getJSON('site_map.json', function(data) {
                var obj = data; //tous le fichier JSON dans un obj
                var site_map = Object.keys(obj);
                var labelEvenement = <?php echo $_SESSION["id_salon"]; ?>;
                document.getElementById("title").innerHTML = labelEvenement;

            });
        });
    </script>

    <header>
        <div class="head_all">
            <a href="/" rel="nofollow" target="">
                <img class="left" src="images/LogoTransparent_GOOD_RESOLUTION.gif" alt="groupe Sogeti" width="30%">
            </a>
            <div>
                <font color="white">
                    <h1 id="title"><?php 
                        echo "Salons";
                    ?></h1>
                </font>
            </div>
        </div>
    </header>
