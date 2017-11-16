<?php
    session_start(); // On démarre la session AVANT toute chose
?>

<?php include('common/header.php'); ?>
    </br>
    <div class="container">
        <a href="add_salon.php" rel="nofollow" target="">
            <button type="button" class="btn btn-success">Ajouter un salon</button>
        </a>
        <h1>Selectionner un salon : </h1>
        </br>
        <div class="panel-group" id="accordion">
        </div>
    </div>

    <script>
        const url = 'http://localhost:8000/salon/1';
        var i = 0;
        var count = 1;
        var z = 0;

        fetch(url)
            .then((resp) => resp.json())
            .then(function(listeSalons) {
                while (listeSalons[i]) {
                    if (listeSalons[i].nom_salon != undefined) {
                        var htmlSalons = "<div class=\"panel panel-default\"><div class=\"panel-heading\"><h4 class=\"panel-title\"><a data-toggle=\"collapse\" data-parent=\"#accordion\"href=\"#collapse";
                        var liste;
                        htmlSalons = htmlSalons + count;
                        htmlSalons = htmlSalons + "\">";
                        htmlSalons = htmlSalons + listeSalons[i].nom_salon;
                        htmlSalons = htmlSalons + "</a></h4></div><div id=\"collapse"
                        htmlSalons = htmlSalons + count;
                        if (count == 1)
                            htmlSalons = htmlSalons + "\" class=\"panel-collapse collapse in\"><div class=\"panel-body\">";
                        else
                            htmlSalons = htmlSalons + "\" class=\"panel-collapse collapse\"><div class=\"panel-body\">";
                        htmlSalons = htmlSalons + "Ville : ";
                        htmlSalons = htmlSalons + listeSalons[i].ville_salon;
                        htmlSalons = htmlSalons + "</br>Description : ";
                        htmlSalons = htmlSalons + listeSalons[i].description;
                        htmlSalons = htmlSalons + "</br>Date de début : ";
                        htmlSalons = htmlSalons + listeSalons[i].date_debut;
                        htmlSalons = htmlSalons + "</br>Date de fin : ";
                        htmlSalons = htmlSalons + listeSalons[i].date_fin;

                        htmlSalons = htmlSalons + "<form enctype=\"multipart/form-data\" action=\"\" name=\"form\" method=\"post\">"
                        htmlSalons = htmlSalons + "<div class=\"form-group\"><input type=\"text\" class=\"form-control\" name=\"my_id\" value=\"";
                        htmlSalons = htmlSalons + listeSalons[i].id_salon;
                        htmlSalons = htmlSalons + "\" style='visibility:hidden;display:none'></div>";
                        htmlSalons = htmlSalons + "<input type=\"submit\" name=\"submit\" class=\"btn btn-primary\"/>"
                        //htmlSalons = htmlSalons + "<button type=\"submit\" class=\"btn btn-success btn-lg btn-block\">Valider</button>"
                        htmlSalons = htmlSalons + "</form>";

                        htmlSalons = htmlSalons + "<form action=\"/list\" name=\"adduser\" method=\"post\">"
                        htmlSalons = htmlSalons + "<div class=\"form-group\"><input type=\"text\" class=\"form-control\" name=\"my_id\" value=\"";
                        htmlSalons = htmlSalons + listeSalons[i].id_salon;
                        htmlSalons = htmlSalons + "\" style='visibility:hidden;display:none'></div>"
                        htmlSalons = htmlSalons + "<button type=\"submit\" class=\"btn btn-primary btn-lg btn-block\">Afficher la liste des visiteurs</button>"
                        htmlSalons = htmlSalons + "</form>";

                        htmlSalons = htmlSalons + "</div></div></div>";
                        document.getElementById("accordion").innerHTML += htmlSalons;
                        count++;
                    }
                    i++;
                }
            })
            .catch((error) => {
                console.log(JSON.stringify(error));
            });
    </script>
    <?php
        if(isset($_POST['submit'])) {
            $id = $_POST['my_id'];
            $_SESSION['id_salon'] = $id;
            echo "<script type='text/javascript'>document.location.replace('http://localhost/AppliContact/');</script>";            
        };
    ?>
<?php include('common/footer.php'); ?>