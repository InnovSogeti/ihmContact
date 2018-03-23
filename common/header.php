<!doctype html><html itemscope="" itemtype="http://schema.org/WebPage" lang="fr">
<?php
session_start(); // On démarre la session AVANT toute chose
// CHargement du fichier de conf
$fichier_conf="config.ini";
if(file_exists ( $fichier_conf )){
    $ini_array = parse_ini_file($fichier_conf);
    print_r($ini_array);
    print_r($ini_array["url_ws_distant"].":".$ini_array["port_ws_distant"]);
}else{
    print_r("FICHIER DE CONF INTROUVABLE");
}
?>

<head>
    <!-- This script loads your compiled module.-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascripts/jsqrscanner.nocache.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--Meta-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#db5945">
    <!--Link-->
    <link rel="icon" sizes="192x192" href="images/sogeti_splash.jpeg">
    <link type="text/css" rel="stylesheet" href="css/JsQRScanner.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="./css/style.css" rel="stylesheet" type="text/css">
    <link rel="manifest" href="scripts/manifest.json">
    <title></title>
</head>
