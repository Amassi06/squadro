<?php

// Inclusion de la classe
require_once 'PieceSquadroUI.php';

// Création d'une instance de la classe
$pieceSquadroUI = new PieceSquadroUI();

?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de la classe PieceSquadroUI</title>
    <!-- Inclusion du fichier CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <script src="./script/sweetalert.js"></script>
    <script src="./script/script.js"></script>
   
</head>
<body>

<div class="game-header">
    <div class="game-title">Squadro</div>
    <div class="game-status">Les blancs jouent</div>
</div>

    <?php
    $piece = new PieceSquadroUI();
    $plateau = $piece->getPlateauObject();
  echo  $pieceSquadroUI->initJeux($plateau);    ?>
</body>
</html>
