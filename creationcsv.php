<script>
function convertToCSV(objArray) {
    var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
    var str = '';

    for (var i = 0; i < array.length; i++) {
        var line = '';
        for (var index in array[i]) {
            if (line != '') line += ','

            line += array[i][index];
        }

        str += line + '\r\n';
    }

    return str;
}

function exportCSVFile(headers, items, fileTitle) {
    if (headers) {
        items.unshift(headers);
    }

    // Convert Object to JSON
    var jsonObject = JSON.stringify(items);

    var csv = this.convertToCSV(jsonObject);

    var exportedFilenmae = fileTitle + '.csv' || 'export.csv';

    var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    if (navigator.msSaveBlob) { // IE 10+
        navigator.msSaveBlob(blob, exportedFilenmae);
    } else {
        var link = document.createElement("a");
        if (link.download !== undefined) { // feature detection
            // Browsers that support HTML5 download attribute
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", exportedFilenmae);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}

function download(){
  var headers = {
      model: 'Phone Model'.replace(/,/g, ''), // remove commas to avoid errors
      chargers: "Chargers",
      cases: "Cases",
      earphones: "Earphones"
  };

  itemsNotFormatted = [
      {
          model: 'Samsung S7',
          chargers: '55',
          cases: '56',
          earphones: '57',
          scratched: '2'
      },
      {
          model: 'Pixel XL',
          chargers: '77',
          cases: '78',
          earphones: '79',
          scratched: '4'
      },
      {
          model: 'iPhone 7',
          chargers: '88',
          cases: '89',
          earphones: '90',
          scratched: '6'
      }
  ];

  var itemsFormatted = [];

  // format the data
  itemsNotFormatted.forEach((item) => {
      itemsFormatted.push({
          model: item.model.replace(/;/g, ''), // remove commas to avoid errors,
          chargers: item.chargers,
          cases: item.cases,
          earphones: item.earphones
      });
  });

  var fileTitle = 'orders'; // or 'my-unique-title'

  exportCSVFile(headers, itemsFormatted, fileTitle); // call the exportCSVFile() function to process the JSON and trigger the download
}
</script>










<?php session_start(); ?>
<?php
header("Content-disposition: attachment; filename=ListeVisiteurs.csv");
header("Content-Type: text/csv");
// Les lignes du tableau

$url = 'localhost:8000/contact/salon/'.$_GET['id_salon'];
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'x-access-token:'. $_GET['token'],
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $listecontacts = json_decode($curl_response,true);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }


$json = $listecontacts;
// Paramétrage de l'écriture du futur fichier CSV
$chemin = 'php://output';
$delimiteur = ";"; // Permet de passe à la cellule suivante
// Création du fichier csv (le fichier est vide pour le moment)
$file = fopen($chemin, 'w');
// les problèmes d'affichage des caractères internationaux (les accents par exemple)
fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
// Boucle foreach qui ajoute chaque ligne au fichiercsv
$header = "";
foreach ($json[0] as $key => $value) {
  $header = $header.$delimiteur.$key;
}
fwrite($file, $header."\n");
$sizejson = count($json);
for ($i=0; $i < $sizejson ; $i++) {
  $ret= "";
  foreach ($json[$i] as $key => $value) {
    $ret= $ret. ";" .str_replace(';', ",", json_encode($value, JSON_HEX_TAG));
  }
  fwrite($file, $ret."\n");
}
fclose($file);

?>
