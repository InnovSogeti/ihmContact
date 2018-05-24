<?php include('common/headerSalon.php'); ?>
<?php require('control_session.php'); ?>
<?php header('Access-Control-Allow-Origin: *');?>

    </br>
    <div class="container">
    <div class="row">
         <div style="padding-top: 10px">
             <a style="color:#ff6e46; font-size: 1.3em" href="/salon.php">
                <?php if (isset($_SESSION['groupe'])) {
                    echo "<- Liste des salons";
                }?>
             </a>
        </div>
    </div>
</div>
<?php
        $url = 'localhost:8000/users';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'x-access-token:'. $_SESSION['token'],
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $listeUsers = json_decode($curl_response,true);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
?>
        <div class="row">
		<div class="hidden-xs col-md-2"></div>
		<div class="col-xs-12 col-md-8">
        <form class="form-signin">
            <h1>
                <select id ="salon" class="btn btn-lg btn-primary btn-block" name="salons"  size="1" onchange="changeUser(this.value)">
                <option>Choisir un utilisateur </option>
                <?php
                foreach($listeUsers as $data){
                    $selected='';
                    echo '<option value="'.$data["_id"].'" '.$selected.'>'.$data["nom"].'</option><br/>';
                }
                ?>
                </select>
            </h1>     
            <div class="form-group">
                <label for="nom">Nom</label>
                <input id = "nom" type="text" class="form-control" name="nom" placeholder="Nom de l'utilisateur" value = "" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prenom</label>
                <input id = "prenom" type="text" class="form-control" name="prenom" placeholder="Prenom de l'utilisateur" value = "" required>
            </div>
            
            <div class="form-group">
                <label for="mail">Mail *</label>
                <input id = "mail" type="text" class="form-control" name="mail" placeholder="Mail" value = "" required>
            </div>
            <div class="form-group">
                <label for="telPro">Téléphone*</label>
                <input id = "telPro" type="text" class="form-control" name="telPro" placeholder="Telephone Professionel" value = "" required>
            </div>
            <div class="form-group">
                <label for="groupe">Groupe*</label>
                <input id = "groupe" type="text" class="form-control" name="groupe" placeholder="Groupe" value = "" required>
            </div>
            <div class="form-group">
                <label for="login">Login*</label>
                <input id = "login" type="text" class="form-control" name="login" placeholder="login" value = "" required>
            </div>
            <div class="form-group">
                <label for="pwd">Mot de passe*</label>
                <input id = "pwd" type="password" class="form-control" name="pwd" placeholder="pwd" value = "" required>
            </div>
            <button type="submit" class="btn btn-success btn-lg btn-block">Valider</button>
            </br>
            <label>* : Champs obligatoire</label>
            </br>
            </br>
        </form>
        </div>
		<div class="hidden-xs col-md-2"></div>
    </div>
    </div>
    <?php
        $_SESSION['id_user']=$_GET['id_user'];

        $url = 'localhost:8000/user/'. $_SESSION['id_user'];
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'x-access-token:'. $_SESSION['token'],
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $user_select = json_decode($curl_response,true);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
?>
    <script> 
        function changeUser(id_user) {          
            window.location.href="/updateUser.php?id_user="+id_user;
        };
        var user_select = <?php echo json_encode($user_select, JSON_HEX_TAG); ?>;

        document.getElementById("nom").value = user_select.nom;
        document.getElementById("prenom").value = user_select.prenom;
        document.getElementById("groupe").value = user_select.groupe;
        document.getElementById("telPro").value = user_select.telPro;
        document.getElementById("mail").value = user_select.mail;
        document.getElementById("login").value = user_select.login;
        document.getElementById("pwd").value = user_select.pwd;

    </script>
        <script> 
    var token = "<?php echo $_SESSION['token'] ;?>";

        /**
         * permet de ne pas save les champs vide
         */
        const isValidElement = element => {
            return element.name && element.value;
        };
        const isValidValue = element => {
            return (!['checkbox', 'radio'].includes(element.type) || element.checked);
        };
        const formToJSON = elements => [].reduce.call(elements, (data, element) => {
            if (isValidValue(element)) {
                if (isCheckbox(element)) {
                    data[element.name] = (data[element.name] || []).concat(element.value); 
                } else {
                    data[element.name] = element.value;
                }
            }
            return data;
        }, {});
        const handleFormSubmit = event => {
            event.preventDefault();
            var data = formToJSON(form.elements);
            var json_form = JSON.stringify(data, null, " ");
            console.log(json_form);
            
            var url= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"]."/user/update/".$_SESSION['id_user'] ?>" ;
            
            var token = "<?php echo $_SESSION['token'];?>";
                
            $.ajax({
                type: "POST",
                url: url,
                contentType :"application/json; charset=utf-8",
                headers:{
                    "x-access-token": token
                },
                dataType : "json",                
                data : json_form,
                
                complete : function(resultat, statut){                 
                    console.log(resultat);
                    
                    window.location.pathname="/salon.php";
                }
                
            });
        };
        const form = document.getElementsByClassName('form-signin')[0];
        form.addEventListener('submit', handleFormSubmit);
        const reducerFunction = (data, element) => {
            data[element.name] = element.value;
            console.log(JSON.stringify(data));
            return (data);
        };
        const isCheckbox = element => element.type === 'checkbox';
        const isMultiSelect = element => element.options && element.multiple;
    </script>
<?php include('common/footer.php'); ?>
