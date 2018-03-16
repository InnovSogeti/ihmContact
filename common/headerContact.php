<?php 
    include('common/header.php'); 
    if(isset($_GET['id_salon'])){
        $_SESSION['id_salon']=$_GET['id_salon'];
        //Interrogation de la ressource Salon pour recuperer le nom et les dates du salon
        $url = 'localhost:8000/salon/'.$_SESSION['id_salon'];
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $salonSelect = json_decode($curl_response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
        
        $_SESSION['nom_salon']=$salonSelect->{'nom'};;
    }
?>
<body>
    <script>
        $(function() {
            $.getJSON('site_map.json', function(data) {
                var obj = data; //tous le fichier JSON dans un obj
                var site_map = Object.keys(obj);

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
                    <a style="color:white;text-decoration:none;" href="/salon.php" target="">
                    <h1 id="title"><?php 
                    if(isset($_SESSION['nom_salon'])){ //Si $var existe.
                        echo $_SESSION['nom_salon'];
                    }
                    ?></h1></a>
                </font>
            </div>
        </div>
    </header>
