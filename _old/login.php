<?php include('common/header.php'); ?>
    <div class="container">
        <h1>Entrez votre mot de passe afin de procéder au tirage au sort :</h1>
        </br>
        </br>
        <form enctype="multipart/form-data" name="form" action="" method="post">
            <input type="password" placeholder="mot de passe" name="mdp"/>
            <input type="submit" name="submit" class="btn btn-primary"/>
        </form>
        </br>
        <?php
            if(isset($_POST['submit'])) {
                $mdp = $_POST['mdp'];
                $url = 'localhost:8000/password/';
                $url = $url . $mdp;
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $curl_response = curl_exec($curl);
                if ($curl_response === false) {
                    $info = curl_getinfo($curl);
                    curl_close($curl);
                    die('error occured during curl exec. Additioanl info: ' . var_export($info));
                }
                curl_close($curl);
                $decoded = json_decode($curl_response);
                if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
                    die('error occured: ' . $decoded->response->errormessage);
                }
                if ($decoded == 200) {
                    header('Location: http://localhost/ihmContact/salon');
                    exit();
                }
            }
        ?>
    </div>
<?php include('common/footer.php'); ?>