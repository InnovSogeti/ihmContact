<?php
    session_start(); // On démarre la session AVANT toute chose

    if(isset($_SESSION['id_salon'])){ //Si $var existe.
        echo ' ';
    }
    else{ //Si $var n'existe pas.

        $url = 'localhost:8000/getSalon';
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
        if ($decoded == 0) {
            header('Location: http://localhost/AppliContact/salon');
            exit();
        }
        else if ($decoded == 1) {
            $url = 'localhost:8000/affSalon';
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
            foreach ($decoded as $val) {
            }
            $_SESSION['id_salon'] = $val;
        }
        else if ($decoded > 1) {
            header('Location: http://localhost/AppliContact/salon');
            exit();
        }
        /**
         * faire une requete pour savoir le nb de salon ajd et en f° du retour ==>
         */
        /*Si 1 salon {
            trouve le salon avc un get salon/jour puis _SESSION = salon;
        }*/
        /*si salon > 1 {
            redirige vers une page (/salon) et affiche les salons dispos avec un /aff/jour
        }
        */
        /*si salon == 0 {
            redirige vers la page de création de salon;
        }
        */
    }
?>
    <!DOCTYPE html>
        <html>
        <?php include('common/header.php'); ?>

        <script type="text/javascript" src="./javascripts/scannedText.js"></script>
        <div class="container">
            <div class="card">
                <form enctype="multipart/form-data" name="form" action="" method="post">
                    <div class="form-group" id="form">
                        <?php
                            $fullInput = "<div class=\"form-group\"><input type=\"text\" class=\"form-control\" name=\"my_id\" value=\"" . $_SESSION['id_salon'] . "\" style='visibility:hidden;display:none'></div>";
                            echo $fullInput;
                        ?>
                        <?php include('common/infos_perso.php'); ?>
                        <?php include('common/infos_competences.php'); ?>
                    </div>
                    </br>
                    <input type="submit" name="submit" class="btn btn-primary" onclick="useradd()"/>
                    </br>
                    <label>* : Champs obligatoire</label>
                    </br>
                    </br>
                </form>
                <script>
                    function useradd() {
                        console.log('CDSCDSCDSCDSCDCDSCDSCCDSCDSCDs');
                    }
                </script>
                <?php
                    if(isset($_POST['submit'])) {
                        echo '<script type="text/javascript">',
                        'useradd();',
                        '</script>';
                        /*$nom = $_POST['nom'];
                        $prenom = $_POST['prenom'];
                        $email = $_POST['email'];
                        $telephone = $_POST['telephone'];
                        $linkedin = $_POST['linkedin'];
                        $viadeo = $_POST['viadeo'];
                        $jeuMario = $_POST['jeuMario'];
                        $jeuPepper = $_POST['jeuPepper'];
                        $ok = $_POST['ok'];
                        $tab = [];
                        $tab[0] = $nom;
                        $tab[1] = $prenom;
                        $tab[2] = $email;
                        $tab[3] = $telephone;
                        $tab[4] = $linkedin;
                        $tab[5] = $viadeo;
                        $tab[6] = $jeuMario;
                        $tab[7] = $jeuPepper;
                        $tab[8] = $ok;
                        print_r($tab);
                        $url = 'localhost:8000/saveUsers' . $tab;
                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_POST, true);                        
                        $curl_response = curl_exec($curl);
                        echo $curl_response;
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
                        echo $decoded;
                        if ($decoded == 200) {
                            header('Location: http://localhost/AppliContact/salon');
                            exit();
                        }*/
                    }
                ?>
            </div>
        </div>
    </body>
    <?php include('common/footer.php'); ?>
</html>



<!--<form enctype="multipart/form-data" name="adduser" methode="post">
    <div class="form-group" id="form">
    <?php
            //$fullInput = "<div class=\"form-group\"><input type=\"text\" class=\"form-control\" name=\"my_id\" value=\"" . $_SESSION['id_salon'] . "\" style='visibility:hidden;display:none'></div>";
            //echo $fullInput;
        ?>
        <?php //include('common/infos_perso.php'); ?>
        <?php //include('common/infos_competences.php'); ?>
    </div>
    </br>
    <button type="submit" class="btn btn-success btn-lg btn-block">Valider</button>
    </br>
    <label>* : Champs obligatoire</label>
    </br>
    </br>
</form>-->