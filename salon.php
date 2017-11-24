<?php
    session_start();
?>

<?php include('common/header.php'); ?>
    </br>
    <div class="container">
        <a href="add_salon.php" rel="nofollow" target="">
            <button type="button" class="btn btn-success">Ajouter un salon</button>
        </a>
        <div id="explication">
        </div>
        <div id="result">
        </div>
        </br>
        <div class="panel-group" id="accordion">
        </div>
    </div>
    <?php 
        $url = 'localhost:8000/salon/1';
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
        $_SESSION['salons'] = $decoded;
    ?>
    <script>
        var i = 0;
        var count = 1;
        var z = 0;

        var listeSalons = <?php echo json_encode($_SESSION['salons'], JSON_HEX_TAG); ?>;
        if (listeSalons[0] == undefined) {
            var choix = "<h1>Aucun salon n'est disponible, veuillez en créer un.</p>";
            document.getElementById("explication").innerHTML += choix;
        }
        else
        {
            var choix = "<h1>Sélectionner un salon : </h1>";
            document.getElementById("explication").innerHTML += choix;
        }
        while (listeSalons[i]) {
            if (listeSalons[i].nom != undefined) {
                var htmlSalons = "<div class=\"panel panel-default\"><div class=\"panel-heading\"><h4 class=\"panel-title\"><a data-toggle=\"collapse\" data-parent=\"#accordion\"href=\"#collapse";
                var liste;

                htmlSalons = htmlSalons + count;
                htmlSalons = htmlSalons + "\">";
                htmlSalons = htmlSalons + listeSalons[i].nom;
                htmlSalons = htmlSalons + "</a></h4></div><div id=\"collapse"
                htmlSalons = htmlSalons + count;
                if (count == 1)
                    htmlSalons = htmlSalons + "\" class=\"panel-collapse collapse in\"><div class=\"panel-body\">";
                else
                    htmlSalons = htmlSalons + "\" class=\"panel-collapse collapse\"><div class=\"panel-body\">";
                htmlSalons = htmlSalons + "Ville : ";
                htmlSalons = htmlSalons + listeSalons[i].ville;
                htmlSalons = htmlSalons + "</br>Description : ";
                htmlSalons = htmlSalons + listeSalons[i].description;
                htmlSalons = htmlSalons + "</br>Date de début : ";
                htmlSalons = htmlSalons + listeSalons[i].date_debut;
                htmlSalons = htmlSalons + "</br>Date de fin : ";
                htmlSalons = htmlSalons + listeSalons[i].date_fin;

                htmlSalons = htmlSalons + "<form enctype=\"multipart/form-data\" action=\"\" name=\"form\" method=\"post\">"
                htmlSalons = htmlSalons + "<div class=\"form-group\"><input id=\"valider\" type=\"text\" class=\"form-control\" name=\"my_id\" value=\"";
                htmlSalons = htmlSalons + listeSalons[i].id_salon;
                htmlSalons = htmlSalons + "\" style='visibility:hidden;display:none'></div>";
                htmlSalons = htmlSalons + "<input type=\"submit\" name=\"submit\" class=\"btn btn-primary btn-lg btn-block\"/>"
                htmlSalons = htmlSalons + "</form>";

                htmlSalons = htmlSalons + "<form enctype=\"multipart/form-data\" class=\"form_aff\" name=\"form\" method=\"post\">"
                htmlSalons = htmlSalons + "<div class=\"form-group\"><input type=\"text\" class=\"form-control\" name=\"aff\" value=\"";
                htmlSalons = htmlSalons + listeSalons[i].id_salon;
                htmlSalons = htmlSalons + "\" style='visibility:hidden;display:none'></div>"
                htmlSalons = htmlSalons + "<button type=\"submit\" name=\"submit\" class=\"btn btn-primary btn-lg btn-block\">Afficher la liste des visiteurs</button>"
                htmlSalons = htmlSalons + "</form>";

                htmlSalons = htmlSalons + "</div></div></div>";
                document.getElementById("accordion").innerHTML += htmlSalons;
                count++;
            }
            i++;
        }
    </script>
    <?php 
        if(isset($_POST['submit'])) {
            if (isset($_POST['my_id'])) {
                $_SESSION['id_salon'] = $_POST['my_id'];
                echo "<script type='text/javascript'>document.location.replace('http://localhost/AppliContact/');</script>";
            }
            if(isset($_POST['aff'])) {
                $_SESSION['id_salon'] = $_POST['aff'];
                echo "<script type='text/javascript'>document.location.replace('http://localhost/AppliContact/list_visiteur.php');</script>";
            }
        };
    ?>
<?php include('common/footer.php'); ?>