<?php include('common/headerContact.php'); ?>

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
        $listeSalonsObj = json_decode($curl_response,true);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
?>
    <div class="container">
        <h1>
            <select name="salons" size="1" onchange="changeSalon(this.value)">
            <?php
            foreach($listeSalonsObj as $data){
                $selected='';
                if(isset($_GET['id_salon']) && $data["_id"]==$_GET['id_salon']){
                    $selected='selected';
                }
                echo '<option value="'.$data["_id"].'" '.$selected.'>'.$data["nom"].'</option><br/>';
            }
            if(isset($_GET['id_salon']) && $_GET['id_salon']=='all'){
                echo '<option value="all" selected >ALL</option><br/>';
            }else{
                echo '<option value="all" >ALL</option><br/>';
            }
            ?>
            </select>
        </h1>
        </br>
            <div id="list">
        </div>
    </div>

    <?php 
        if(isset($_GET['id_salon'])){
            if($_GET['id_salon'] == 'all'){
                $url = 'localhost:8000/contact';
            }else{
                $url = 'localhost:8000/contact/salon/'. $_GET['id_salon'];    
            }
        }
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

    <script>
        var list = <?php echo json_encode($_SESSION['visiteurs'], JSON_HEX_TAG); ?>;
        var i = 0;
        var visiteurs = "<table><tr><th>Nom</th><th>Prenom</th><th>Numéro de téléphone</th><th>Email</th></tr>";

        while (list[i]) {
            if (list[i]) {
                visiteurs = visiteurs + "<tr><td>";
                visiteurs = visiteurs + list[i].nom;
                visiteurs = visiteurs + "</td><td>";
                visiteurs = visiteurs + list[i].prenom;
                visiteurs = visiteurs + "</td><td>";
                visiteurs = visiteurs + list[i].telephone;
                visiteurs = visiteurs + "</td><td>";
                visiteurs = visiteurs + list[i].email;
                visiteurs = visiteurs + "</td></tr>";
            }
            i++;
        }
        visiteurs = visiteurs + "</table>"
        document.getElementById("list").innerHTML += visiteurs;

        function changeSalon(idSalon) {
            window.location.href="/contact.php?id_salon="+idSalon;
        }
    </script>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
            background-color: #ff4511;
            color: white;
        }
    </style>
    </br>
    </br>
    </br>
    <?php include('common/footer.php'); ?>
</html>