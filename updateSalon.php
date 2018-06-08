<?php include('common/headerSalon.php'); ?>
<?php header('Access-Control-Allow-Origin: *');?>

    <script>
        function extractUrlParams(){   
            var t = location.search.substring(1).split('?');
            var f = [];
            for (var i=0; i<t.length; i++){
                var x = t[ i ].split('=');
                f[x[0]]=x[1];
            }
            return f;
        }
            var listeparam = extractUrlParams();
            var token = listeparam.token;  
            var idSalon = listeparam.id_salon;            
    </script>
    </br>
    <div class="container">
    <a style="color:#ff6e46; font-size: 1.3em" onclick="retourlistesalons()">
        <button><- Liste des salons </button>
    </a>
    <div class="row">
		<div class="hidden-xs col-md-2"></div>
		<div class="col-xs-12 col-md-8">
        <form class="form-signin">
            <div class="form-group">
                <label for="ville">Ville du salon *</label>
                <input id = "ville" type="text" class="form-control" name="ville" placeholder="ville du salon" value = "" required>
            </div>
            <div class="form-group">
                <label for="nom">Nom du salon *</label>
                <input id="nom_salon" type="text" class="form-control" name="nom" placeholder="nom du salon" required>
            </div>
            <div class="form-group">
                <label for="description">Description du salon:</label>
                <textarea id = "description" class="form-control" rows="3" name="description"></textarea>
            </div>
            <div class="form-group">
            <label for="logo">logo</label>
                <input type="file" name="logo_salon" />
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
            </div>
            <div class="form-group">
                <label for="date_debut">Du : *</label>
                <input id="date_debut" type="date" class="form-control" name="date_debut" required>
            </div>
            <div class="form-group">
                <label for="date_fin">Au : *</label>
                <input id = "date_fin" type="date" class="form-control" name="date_fin" required>
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
    function retourlistesalons() {
        window.location.href="/salon.php?token="+token
    }
    
    var url= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"] ?>" ;

    $(document).ready(function () {
        $.ajax({
            type: "GET",
            url: url+'/salon/'+ idSalon,
            contentType :"application/json; charset=utf-8",
            headers:{
                "x-access-token": token
            },
            dataType : "json",                                
            success : function(salon_courant) {
                
                document.getElementById("ville").value = salon_courant.ville;
                document.getElementById("nom_salon").value = salon_courant.nom;
                document.getElementById("description").value = salon_courant.description;
                document.getElementById("date_debut").value = salon_courant.date_debut;
                document.getElementById("date_fin").value = salon_courant.date_fin;
            }
        })
    });

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
            
            var url2= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"]."/salon/update/"?>"+idSalon ;
                
            $.ajax({
                type: "POST",
                url: url2,
                contentType :"application/json; charset=utf-8",
                headers:{
                    "x-access-token": token
                },
                dataType : "json",                
                data : json_form,
                
                complete : function(resultat, statut){                 
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
