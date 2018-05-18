Configuration du débuggueur:
===
- Dans Visual Studio Code, installer l'extension "PHP Dbug"
- Dans le fichier php.ini, ajouter les lignes suivantes :
```
xdebug.remote_enable = 1
xdebug.remote_autostart = 1
```
- Dans Visual Studio Code :
  - Aller dans la vue Debug
  - Dans la liste déroulante à droite de DEBOGUER sélectionner "Ajouter une configuration"
  - Dans la boite de dialogue, sélectionner PHP
  - Le fichier "launch.json" est créé
  - Enregistrer ce fichier "launch.json" sans rien modifier

Lancer le Debug : 
===
- Dans Visual Studio Code :
  - Cliquer sur la flèche verte à droite de DEBOGUER dans la vue Debug
  - Mettre un point d'arrêt dans un fichier php
  - Aller sur la page de ce fichier php
