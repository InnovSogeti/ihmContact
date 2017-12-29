<?php include('common/header.php'); ?>
    </br>
    <div class="container">
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

            $.ajax({
                type: "POST",
                url: 'http://localhost:8000/addSalons',
                dataType : "json",
                contentType: "application/json; charset=utf-8",
                data : json_form,
                success : function(result) {
                    console.log(result);
                    if (result == 200) {
                        header('Location: http://localhost/ihmContact/salon');
                        exit();
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