<?php include('common/headerContact.php'); ?>
    <script type="text/javascript" src="./javascripts/scannedText.js"></script>
    <div class="container">
        <form class="form-signin">
            <div class="form-group" id="form">
                <?php
                    $fullInput = "<div class=\"form-group\"><input type=\"text\" class=\"form-control\" name=\"my_id\" value=\"" . $_SESSION['nom_salon'] . "\" style='visibility:hidden;display:none'></div>";
                    echo $fullInput;
                ?>
                <?php include('common/infos_perso.php'); ?>
                <?php include('common/infos_competences.php'); ?>
            </div>
            </br>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Envoyer</button>
            </br>
            <label>* : Champs obligatoire</label>
            </br>
            </br>
        </form>
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

            $.ajax({
                type: "POST",
                url: 'http://localhost:8000/saveUsers',
                dataType : "json",
                contentType: "application/json; charset=utf-8",
                data : json_form,
                success : function(result) {
                    if (result == 200) {
                        window.location = "http://localhost/ihmContact/";
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