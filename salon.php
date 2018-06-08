<?php 
include('common/headerSalon.php');
 ?>
    </br>
    <script> 


     // get our config file   
        function extractUrlParams(){   
            var t = location.search.substring(1).split('&');
            var f = [];
            for (var i=0; i<t.length; i++){
                var x = t[ i ].split('=');
                f[x[0]]=x[1];
            }
            return f;
        }
        var token = extractUrlParams().token;
    </script>
    <div class="container">
        <a onclick="addSalon()" rel="nofollow" target="">
            <button type="button" class="btn btn-lg btn-primary btn-block">Ajouter un salon</button>
        </a> <br>
        <a onclick="updateUser()" rel="nofollow" target="">
            <button type="button" class="btn btn-lg btn-primary btn-block">Gestion des utilisateurs</button>
        </a>
        <div id="explication"></div>
        <div id="result"></div>
        <div class="panel-group" id="accordion"></div>
    </div>
    <script>
    
    var url= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"] ?>" ;
    var listeSalons
    $(document).ready(function () {
        $.ajax({
                type: "GET",
                url: url+'/salon/',
                contentType :"application/json; charset=utf-8",
                headers:{
                    "x-access-token": token
                },
                dataType : "json",                                
                success : function(result) {
                    var listeSalons = result;                 
                    var i = 0;
                    var count = 1;
                    var z = 0;

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
                            html += "<button type=\"submit\" name=\"sub_update\" class=\"btn btn-success btn-lg btn-block\" onclick=\"updateSalon('"+listeSalons[i]._id+"')\">Modifier</button>"
                            html += "<button type=\"submit\" id=\"del_"+listeSalons[i]._id+"\" class=\"btn btn-success btn-lg btn-block\" onclick=\"deleteSalon('"+listeSalons[i]._id+"')\">Supprimer</button>"

                            html += "</div></div></div>";
                            document.getElementById("accordion").innerHTML += html;

                            count++;
                        }
                        i++;
                    }

                },                
            });
    })

        function choisirSalon(idSalon){
            window.location.href="/index.php?token="+token+"?id_salon="+idSalon;
        }
        function afficherContactsSalon(idSalon){
            window.location.href="/contact.php?token="+token+"?id_salon="+idSalon;
        }
        function updateSalon(idSalon){
            window.location.href="/updateSalon.php?token="+token+"?id_salon="+idSalon;
        }
        function addSalon(){
            window.location.href="/add_salon.php?token="+token;
        }
        function updateUser(){
            window.location.href="/updateUser.php?token="+token+"?id_user=adduser";
        }

        function deleteSalon(idSalon){
          if (confirm("Voulez-vous supprimer ce salon ?")) {
            var url= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"] ?>" ;
            $.ajax({
                type: "DELETE",
                url: url+'/salon/'+idSalon,
                headers:{
                    "x-access-token": token
                },
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