<?php session_start(); ?>
<?php
header("Content-disposition: attachment; filename=ListeVisiteurs.csv");
header("Content-Type: text/csv");
// Les lignes du tableau
$json = $_SESSION['visiteurs'];
// Paramétrage de l'écriture du futur fichier CSV
$chemin = 'php://output';
$delimiteur = ";"; // Permet de passe à la cellule suivante
// Création du fichier csv (le fichier est vide pour le moment)
$file = fopen($chemin, 'w');
// les problèmes d'affichage des caractères internationaux (les accents par exemple)
fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
// Boucle foreach qui ajoute chaque ligne au fichiercsv
// var_dump(array_keys($json[0]));
$header = "";
foreach ($json[0] as $key => $value) {
  $header = $header . ";" .$key;
}
fwrite($file, $header."\n");
$sizejson = count($json);
for ($i=0; $i < $sizejson ; $i++) {
  $val = "";
  foreach ($json[$i] as $key => $value) {
    $val = $val . ";" .str_replace(';', ",", json_encode($value, JSON_HEX_TAG));
  }
  fwrite($file, $val."\n");
}
fclose($file);

?>
