<?php include('common/headerSalon.php'); ?>
<?php require('control_session.php'); ?>

    </br>
    <?php $_SESSION['id_salon']=$_GET['id_salon']; ?>
    <div class="container">
    <a style="color:#ff6e46; font-size: 1.3em" href="/salon.php">
                <?php if (isset($_SESSION['groupe'])) {
                    echo "<- Liste des salons";
                }?>
    </a>
    <?php
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
        $saloncourant = json_decode($curl_response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
    ?>
    <script> 
    var salon_courant = <?php echo json_encode($saloncourant, JSON_HEX_TAG); ?>;
    var nom = salon_courant.nom;
    var ville = salon_courant.ville;
    var description = salon_courant.description;

    </script>

    <div class="row">
		<div class="hidden-xs col-md-2"></div>
		<div class="col-xs-12 col-md-8">
        <form class="form-signin">
            <div class="form-group">
                <label for="ville">Ville du salon *</label>
                <input type="text" class="form-control" name="ville" placeholder="ville du salon" required>
            </div>
            <div class="form-group">
                <label for="nom">Nom du salon *</label>
                <input type="text" class="form-control" name="nom" placeholder="nom du salon" required>
            </div>
            <div class="form-group">
                <label for="description">Description du salon:</label>
                <textarea class="form-control" rows="3" name="description"></textarea>
            </div>
            <div class="form-group">
            <label for="logo">logo</label>
                <input type="file" name="logo_salon" />
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
            </div>
            <div class="form-group">
                <label for="date_debut">Du : *</label>
                <input type="date" class="form-control" name="date_debut" required>
            </div>
            <div class="form-group">
                <label for="date_fin">Au : *</label>
                <input type="date" class="form-control" name="date_fin" required>
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
    <script>
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
            const data = formToJSON(form.elements);
            var json_form = JSON.stringify(data, null, " ");
            console.log(json_form);
            
            var url= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"]."/salon/update/".$_SESSION['id_salon'] ?>" ;
            $.ajax({
                type: "POST",
                url: url,
                dataType : "json",
                contentType: "application/json; charset=utf-8",
                data : json_form,
                success : function(result) {
                    console.log(result);
                    if (result == 200) {
                        window.location.pathname="/salon.php";
                    }
                    else {
                        alert("erreur 500: veuillez recommencer")
                    }
                },
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
