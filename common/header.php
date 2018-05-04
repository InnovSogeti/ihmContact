<!doctype html>
<html itemscope="" itemtype="http://schema.org/WebPage" lang="fr">
<?php session_start(); ?>
<?php
$fichier_conf="config.ini";
if(file_exists($fichier_conf)) {
    $ini_array = parse_ini_file($fichier_conf);
} else {
    print_r("FICHIER DE CONF INTROUVABLE");
}
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#db5945">
    <link rel="icon" sizes="192x192" href="images/sogeti_splash.jpeg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--
    <script type="text/javascript" src="javascripts/jsqrscanner.nocache.js"></script>
    <link type="text/css" rel="stylesheet" href="css/JsQRScanner.css">
    -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="manifest.json" rel="stylesheet">
</head>
