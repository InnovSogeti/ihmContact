<?php include('common/header.php'); ?>
<script language="JavaScript" type="text/javascript">

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
    var id_salon = listeparam.id_salon;
        

</script>

<body>
    <script>
        $(function() {
            $.getJSON('site_map.json', function(data) {
                var obj = data; //tous le fichier JSON dans un obj
                var site_map = Object.keys(obj);

            });
        });
    </script>
    <div class="container-fluid">
        <div class="row" style="background-color: #ff6e46">
            <div class="col-xs-7">
                <h1 class="title"> <div id = "nom_salon"></div></h1>
            </div>
            <div class="col-xs-5">
                    <img class="logo" src="images/LogoTransparent_GOOD_RESOLUTION.gif" alt="groupe Sogeti">
            </div>

        </div>
        <script>
        $(document).ready(function () {
            if (id_salon) {
                var url= "http://localhost:8000/salon/"+id_salon;
                    
                $.ajax({
                    type: "GET",
                    url: url,
                    contentType :"application/json; charset=utf-8",
                    dataType : "json",                                
                    success : function(salon_choisi) {
                        document.getElementById("nom_salon").innerHTML += salon_choisi.nom;
                    }
                })
            }    
            else { 
                var url= "http://localhost:8000/getSalonCourant";
                $.ajax({
                    type: "GET",
                    url: url,
                    contentType :"application/json; charset=utf-8",
                    dataType : "json",                                
                    success : function(salon_courant) {
                        console.log(salon_courant.length);
                        if (salon_courant.length > 1) {
                            var listeSalon = "<h1>";
                            var selected= '';
                            var i = 0;
                            listeSalon += "<select id = 'salon' class='btn btn-lg btn-primary btn-block' name='salon_courant'  size='1' onchange='changeSalonCourant(this.value)'>";
                            listeSalon += "<option> Veuilez choisir un salon ! </option>"
                            while (salon_courant[i]) {
                                if (salon_courant[i]) {
                                    selected= '';
                                    if (salon_courant[i]._id == id_salon) {
                                        selected = 'selected'; 
                                    }
                                    listeSalon += "<option value ="+salon_courant[i]._id+" "+selected+">"+salon_courant[i].nom+"</option>";
                                }
                                i++;
                            }
                            document.getElementById("listesaloncourant").innerHTML += listeSalon;      
                        }
                        else {                            
                            document.getElementById("nom_salon").innerHTML = salon_courant[0].nom;
                            window.location.href="/index.php?id_salon="+salon_courant[0]._id;                            
                        }
                    }
                })
            }
        })
        function changeSalonCourant(idSalon) {          
            window.location.href="/index.php?id_salon="+idSalon;
        }
        </script>
    </div>
 
