<?php
    include('common/header.php');
?>
<body>
    <script>
        $(function() {
            $.getJSON('site_map.json', function(data) {
                var obj = data; //tous le fichier JSON dans un obj
                var site_map = Object.keys(obj);

            });
        });
    </script>

    <header>
        <div class="container-fluid">
            <div class="row" style="background-color: #ff6e46">
                <div class="col-xs-7">
                    <h1 class="title"><?php
                            echo 'Authentification';
                    ?></h1>
                </div>
                <div class="col-xs-5">
                    <a class="logo" href="/" rel="nofollow">
                        <img class="logo" src="images/LogoTransparent_GOOD_RESOLUTION.gif" alt="groupe Sogeti">
                    </a>
                </div>
            </div>
        </div>
    </header>