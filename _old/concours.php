<?php include('common/header.php'); ?>
    <div class="container">
        </br>
        <div id="random">
            <ul class="name">
            </ul>
        </div>
        </br>
    </div>
    <?php 
        $url = 'localhost:8000/tirage/' . $_SESSION['id_salon'];
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
        $_SESSION['visiteurs'] = $decoded;
    ?>
    <div class="container" id="tab">
        </br>
    </div>
    </br>
    <script>
        var nb = <%- JSON.stringify(nb) %>;
        var list = <%- JSON.stringify(list) %>;
        var i = 0;
        var htmlList = "<table><tr><th>Nom</th><th>Prenom</th><th>Email</th></tr>";

        while (list[i]) {
            htmlList = htmlList + "<tr><td>";
            htmlList = htmlList + list[i].nom;
            htmlList = htmlList + "</td><td>";
            htmlList = htmlList + list[i].prenom;
            htmlList = htmlList + "</td><td>";
            htmlList = htmlList + list[i].email;
            htmlList = htmlList + "</td></tr>";
            i++;
        }
        htmlList = htmlList + "</table>"
        document.getElementById("tab").innerHTML += htmlList;
    </script>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        
        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        
        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
<?php include('common/footer.php'); ?>