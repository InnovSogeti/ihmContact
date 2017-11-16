<% include common/header %>
    <div class="container">
        <h1>Liste des visiteurs du salon :</h1>
        </br>
        <div id="list">
        </div>
    </div>

    <script>
        var list = <%- JSON.stringify(list) %>;
        var my_id = <%- JSON.stringify(my_id) %>;
        var i = 0;

        while (list[i]) {
            if (list[i].id_salon == my_id) {
                visiteurs = "<p>Nom : ";
                visiteurs = visiteurs + list[i].nom;
                visiteurs = visiteurs + ", Prenom : ";
                visiteurs = visiteurs + list[i].prenom;
                visiteurs = visiteurs + ", email : "
                visiteurs = visiteurs + list[i].email;
                visiteurs = visiteurs + "</p></br>";
                document.getElementById("list").innerHTML += visiteurs;
                console.log(list[i]);
            }
            i++;
        }
    </script>
    <% include common/footer %>