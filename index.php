<?php include('common/headerContact.php'); ?>
<script type="text/javascript" src="./javascripts/scannedText.js"></script>
<div class="container">
    <div class="row">
		<div class="hidden-xs col-md-2"></div>
		<div class="col-xs-12 col-md-8">
            <div id="all">
                <img class="background" src="images/oser.png" alt="groupe Capgemini" width="100%">
            </div>
            <form class="form-signin">
                <div class="form-group" id="form">
                    <input type="hidden" name="id_salon" value="<?php echo $_SESSION['id_salon'] ?>">
                    <?php include('common/infos_perso.php'); ?>
                    <?php include('common/infos_competences.php'); ?>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Envoyer</button>
                    </div>
                </div>
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
            console.log(json_form);
            var url= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"] ?>" ;
            $.ajax({
                type: "POST",
                url: url+'/contact/add',
                dataType : "json",
                contentType: "application/json; charset=utf-8",
                data : json_form,
                success : function(result) {
                    console.log(result);
                    if (result == 200) {
                        window.location.pathname="/index.php";
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
            return (data);
        };
        const isCheckbox = element => element.type === 'checkbox';
        const isMultiSelect = element => element.options && element.multiple;
    </script>
    <?php include('common/footer.php'); ?>
</html>
