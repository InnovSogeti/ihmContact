<?php 
include('common/headerSalon.php');
 ?>
    </br>
    <?php require('control_session.php'); ?>        
    <div class="container">
        <a href="add_salon.php" rel="nofollow" target="">
            <button type="button" class="btn btn-success">Ajouter un salon</button>
        </a>
        <div id="explication"></div>
        <div id="result"></div>
        <div class="panel-group" id="accordion"></div>
    </div>
    <?php
        $url = 'localhost:8000/salon';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $listeSalonsObj = json_decode($curl_response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
    ?>
    <script>
        var i = 0;
        var count = 1;
        var z = 0;

        var listeSalons = <?php echo json_encode($listeSalonsObj, JSON_HEX_TAG); ?>;
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
                var html = "<div class=\"panel panel-default\"><div class=\"panel-heading\"><h4 class=\"panel-title\"><a data-toggle=\"collapse\" data-parent=\"#accordion\"href=\"#collapse";
                var liste;

                html += count;
                html += "\">";
                html += listeSalons[i].nom;
                html += "</a></h4></div><div id=\"collapse"
                html += count;
                if (count == 1)
                    html += "\" class=\"panel-collapse collapse in\"><div class=\"panel-body\">";
                else
                    html += "\" class=\"panel-collapse collapse\"><div class=\"panel-body\">";
                html += "Ville : ";
                html += listeSalons[i].ville;
                html += "</br>Description : ";
                html += listeSalons[i].description;
                html += "</br>Date de début : ";
                html += listeSalons[i].date_debut;
                html += "</br>Date de fin : ";
                html += listeSalons[i].date_fin;

                html += "<div class=\"form-group\">"
                html += "<input id=\"id_salon\" type=\"text\" class=\"form-control\" name=\"id_salon\" value=\"";
                html += listeSalons[i]._id;
                html += "\" style='visibility:hidden;display:none'>"
                html += "</div>";
                html += "<button type=\"submit\" name=\"sub_select\" class=\"btn btn-success btn-lg btn-block\" onclick=\"choisirSalon('"+listeSalons[i]._id+"')\">Choisir</button>"
                html += "<button type=\"submit\" name=\"sub_contact\" class=\"btn btn-success btn-lg btn-block\" onclick=\"afficherContactsSalon('"+listeSalons[i]._id+"')\">Afficher la liste des visiteurs</button>"
                // html += "<button type=\"submit\" name=\"sub_update\" class=\"btn btn-success btn-lg btn-block\" onclick=\"modifierSalon('"+listeSalons[i]._id+"')\">Modifier</button>"
                html += "<button type=\"submit\" id=\"del_"+listeSalons[i]._id+"\" class=\"btn btn-success btn-lg btn-block\" onclick=\"deleteSalon('"+listeSalons[i]._id+"')\">Supprimer</button>"

                html += "</div></div></div>";
                document.getElementById("accordion").innerHTML += html;

                count++;
            }
            i++;
        }

        function choisirSalon(idSalon){
            window.location.href="/index.php?id_salon="+idSalon;
        }

        function afficherContactsSalon(idSalon){
            window.location.href="/contact.php?id_salon="+idSalon;
        }


        function deleteSalon(idSalon){
          if (confirm("Voulez-vous supprimer ce salon ?")) {
            var url= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"] ?>" ;
            $.ajax({
                type: "DELETE",
                url: url+'/salon/'+idSalon,
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
          }
        }
    </script>

<?php include('common/footer.php'); 