<?php include('common/headerSalon.php'); ?>
<?php require('control_session.php'); ?>

    </br>
    
    <div class="container">
    <a style="color:#ff6e46; font-size: 1.3em" href="/salon.php">
                <?php if (isset($_SESSION['groupe'])) {
                    echo "<- Liste des salons";
                }?>
    </a>
    <div class="row">
		<div class="hidden-xs col-md-2"></div>
		<div class="col-xs-12 col-md-8">
        <form class="form-signin">
            <div class="form-group">
                <label for="ville_salon">Ville du salon *</label>
                <input type="text" class="form-control" name="ville_salon" placeholder="ville du salon" required>
            </div>
            <div class="form-group">
                <label for="nom_salon">Nom du salon *</label>
                <input type="text" class="form-control" name="nom_salon" placeholder="nom du salon" required>
            </div>
            <div class="form-group">
                <label for="description_salon">Description du salon:</label>
                <textarea class="form-control" rows="3" name="description_salon"></textarea>
            </div>
            <div class="form-group">
            <label for="logo_salon">logo</label>
                <input type="file" name="logo_salon" />
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
            </div>
            <div class="form-group">
                <label for="debut_salon">Du : *</label>
                <input type="date" class="form-control" name="debut_salon" required>
            </div>
            <div class="form-group">
                <label for="fin_salon">Au : *</label>
                <input type="date" class="form-control" name="fin_salon" required>
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
                if (isCheckbox(element)) { data[element.name] = (data[element.name] || []).concat(element.value); } else {
                    data[element.name] = element.value;
                }
            }
            return data;
        }, {});
        const handleFormSubmit = event => {
            event.preventDefault();
            const data = formToJSON(form.elements);
            var json_form = JSON.stringify(data, null, " ");
            var url= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"] ?>" ;
            var token = "<?php echo $_SESSION['token'];?>";

            $.ajax({
                
                type: "POST",
                url: url+'/salon/add',
                contentType: "application/json; charset=utf-8",
                headers:{
                    "x-access-token": token
                },
                dataType : "json",
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
                error : function(resultat, statut, erreur){
                    console.log(resultat);
                    console.log(token);
                                      
                },
                // complete : function(resultat, statut){
                //         // console.log(resultat);
                // }
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
