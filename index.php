<?php
    session_start(); // On démarre la session AVANT toute chose

    if(isset($_SESSION['id_salon'])){ //Si $var existe.
        echo $_SESSION['id_salon'];
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
        echo $decoded;
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
    }
?>
    <!DOCTYPE html>
        <html>
        <?php include('common/header.php'); ?>
        <script type="text/javascript" src="./javascripts/scannedText.js"></script>
        <div class="container">
            <form class="form-signin">
                <div class="form-group" id="form">
                    <?php
                        $fullInput = "<div class=\"form-group\"><input type=\"text\" class=\"form-control\" name=\"my_id\" value=\"" . $_SESSION['id_salon'] . "\" style='visibility:hidden;display:none'></div>";
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
    </body>
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
                        window.location = "http://localhost/AppliContact/";
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
            //console.log(JSON.stringify(data));
            return (data);
        };
        const isCheckbox = element => element.type === 'checkbox';
        const isMultiSelect = element => element.options && element.multiple;
    </script>
    <?php include('common/footer.php'); ?>
</html>