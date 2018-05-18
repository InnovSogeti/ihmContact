<?php
    include('common/header.php');
    if(isset($_GET['id_salon'])){
        if($_GET['id_salon']=='all'){
            //$_SESSION['nom_salon']='all';
            unset($_SESSION['nom_salon']);
        }else{
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
    }else{
        header("Location: /index.php?id_salon=5ad489fff469632ba4aa0000");
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
    <div class="container-fluid">
        <div class="row" style="background-color: #ff6e46">
            <div class="col-xs-7">
                <h1 class="title"><?php
                    if(isset($_SESSION['nom_salon'])){ //Si $var existe.
                        echo $_SESSION['nom_salon'];
                    }else{
                        echo 'Salons';
                    }
                ?></h1>
                <?php
                if (isset($_SESSION['groupe'])) {
                    echo '<a href="./deconnect.php"><button class="btn btn-success">Se déconnecter </button></a>';
                }
                else {
                    echo '<a href="./authentification.php"><button class="btn btn-success">Se connecter </button></a>';
                }
                ?>
            </div>
            <div class="col-xs-5">
                    <img class="logo" src="images/LogoTransparent_GOOD_RESOLUTION.gif" alt="groupe Sogeti">
            </div>
        </div>
    </div>
 
