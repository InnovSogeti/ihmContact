<?php include('common/headerAuthentification.php');?>

<div class="container">
    <div class="row">
            <div class="hidden-xs col-md-2"></div>
            <div class="col-xs-12 col-md-8">
    <h2>Inscription</h2>
    <div class="row-element-set row-element-set-QRScanner">
        <div id="all">
            <img class="background" src="images/oser.png" alt="groupe Capgemini" width="100%">
        </div>
        </br>
        <form class="form-signin">
            <div class="row-element">
                <div class="form-field form-field-memo">
                    <div class="FlexPanel form-field-input-panel">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" class="form-control" name="login" placeholder="Login" id="login" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Mot de passe</label>
                        <input type="password" class="form-control" name="pwd" placeholder="Mot de passe" id="pwd" required>
                    </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
        </form>
    </br>
    </div>
    </div>
		<div class="hidden-xs col-md-2"></div>
    </div>
</div>



</br></br>

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

        $.ajax({
            type: "POST",
            url: url+'/authenticate',
            dataType : "json",
            contentType: "application/json; charset=utf-8",
            data : json_form,
            success : function(result) { 
                if (result.token) {
                    // setcookie("token",result.token);
                    document.cookie = 'token='+result.token+'; expires=Thu, 2 Aug 2022 20:47:11 UTC; path=/'
                    window.location.href="/salon.php?token=" + result.token; 
                }
                else {
                    alert("Mauvais login ou mot de passe");
                }
            },
            error : function(resultat, statut, erreur){                
                alert("Erreur");          
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
