<?php include('common/headerSalon.php'); ?>
<?php header('Access-Control-Allow-Origin: *');?>
<script>
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
    var id_user = listeparam.id_user;

    function retourlistesalons() {
        window.location.href="/salon.php?token="+token
    }
    function changeUser(choix) {
                window.location.href="/updateUser.php?token="+token+"?id_user="+choix;  
    };

    $(document).ready(function () {
            var url= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"] ?>"+'/users';
            console.log(url);
            console.log(token);
            
            $.ajax({
                type: "GET",
                url: url,
                contentType :"application/json; charset=utf-8",
                headers:{
                    "x-access-token": token
                },
                dataType : "json",                                
                success : function(users) {
                    console.log(users);
                    
                    var listeUser = "<h1>";
                    var selected= '';
                    var i = 0;
                    listeUser += "<SELECT id ='salon' class='btn btn-lg btn-primary btn-block' name='salons'  size='1' onchange='changeUser(this.value)'>";
                    listeUser += "<option value = 'adduser'> Ajouter un utilisateur </option>";
                    while (users[i]) {
                        if (users[i]) {
                            selected= '';
                            if (users[i]._id == id_user) {
                                selected = 'selected'; 
                            }
                            listeUser += "<option value ="+users[i]._id+" "+selected+">"+users[i].nom+"</option>";
                        }
                        i++;
                    }               
                    listeUser += "</select> </h1>"; 
                    document.getElementById("listUser").innerHTML += listeUser;
                }
            })
        if (id_user != "adduser") {
            var url= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"] ?>"+'/user/'+ id_user;
            $.ajax({
                type: "GET",
                url: url,
                contentType :"application/json; charset=utf-8",
                headers:{
                    "x-access-token": token
                },
                dataType : "json",                                
                success : function(user_select) {
                    console.log(user_select);
                    
                    document.getElementById("nom").value = user_select.nom;
                    document.getElementById("prenom").value = user_select.prenom;
                    document.getElementById("groupe").value = user_select.groupe;
                    document.getElementById("telPro").value = user_select.telPro;
                    document.getElementById("mail").value = user_select.mail;
                    document.getElementById("login").value = user_select.login;
                    document.getElementById("pwd").value = user_select.pwd;
                }
            })
        }
    });



</script>
    </br>
    <div class="container">
        <div class="row">
            <div style="padding-top: 10px">
            <a style="color:#ff6e46; font-size: 1.3em" onclick="retourlistesalons()">
                <button><- Liste des salons </button>
            </a>
            </div>
        </div>
        </br>
    </div>
        <div class="row">
		<div class="hidden-xs col-md-2"></div>
		<div class="col-xs-12 col-md-8">
        <div id="listUser"> </div>
        <form class="form-signin">   
            <div class="form-group">
                <label for="nom">Nom</label>
                <input id = "nom" type="text" class="form-control" name="nom" placeholder="Nom de l'utilisateur" value = "" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prenom</label>
                <input id = "prenom" type="text" class="form-control" name="prenom" placeholder="Prenom de l'utilisateur" value = "" required>
            </div>
            
            <div class="form-group">
                <label for="mail">Mail *</label>
                <input id = "mail" type="text" class="form-control" name="mail" placeholder="Mail" value = "" required>
            </div>
            <div class="form-group">
                <label for="telPro">Téléphone*</label>
                <input id = "telPro" type="text" class="form-control" name="telPro" placeholder="Telephone Professionel" value = "" required>
            </div>
            <div class="form-group">
                <label for="groupe">Groupe*</label>
                <input id = "groupe" type="text" class="form-control" name="groupe" placeholder="Groupe" value = "" required>
            </div>
            <div class="form-group">
                <label for="login">Login*</label>
                <input id = "login" type="text" class="form-control" name="login" placeholder="login" value = "" required>
            </div>
            <div class="form-group">
                <label for="pwd">Mot de passe*</label>
                <input id = "pwd" type="password" class="form-control" name="pwd" placeholder="pwd" value = "" required>
            </div>
            <button type="submit" class="btn btn-success btn-lg btn-block">Valider</button>
            </br>
            <label>* : Champs obligatoire</label>
            </br>
            </br>
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
                 if (isCheckbox(element)) {
                    data[element.name] = (data[element.name] || []).concat(element.value); 
                } else {
                    data[element.name] = element.value;
                }
            }
            return data;
        }, {});
        const handleFormSubmit = event => {
            event.preventDefault();
            var data = formToJSON(form.elements);
            var json_form = JSON.stringify(data, null, " ");
            console.log(json_form);
            var choixurl = id_user;
            
            if (choixurl == "adduser") {
                var url= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"]."/users/add" ?>";
            } else {
                var url= "<?php echo $ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"]."/user/update/"?>"+id_user ;
            }
                
            $.ajax({
                type: "POST",
                url: url,
                contentType :"application/json; charset=utf-8",
                headers:{
                    "x-access-token": token
                },
                dataType : "json",                
                data : json_form,
                
                complete : function(resultat, statut){                 
                    console.log(resultat);
                    
                    window.location.pathname="/salon.php";
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
