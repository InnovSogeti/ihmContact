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
        <div class="head_all">
            <a href="/" rel="nofollow" target="">
                <img class="left" src="images/LogoTransparent_GOOD_RESOLUTION.gif" alt="groupe Sogeti" width="30%">
            </a>
            <div>
                <font color="white">
                    <h1 id="title"><?php
                        echo "Authentification";
                    ?></h1>
                </font>
            </div>
        </div>
    </header>
