<?php

require_once 'PieceSquadro.php'; // Chargez votre classe PieceSquadro
require_once 'ArrayPieceSquadro.php'; // Chargez votre classe ArrayPieceSquadro

// Initialisation des objets PieceSquadro
$pieceVide = PieceSquadro::initVide();
$pieceNeutre = PieceSquadro::initNeutre();
$pieceNoirNord = PieceSquadro::initNoirNord();
$pieceBlancEst = PieceSquadro::initBlancEst();

// Initialisation de l'objet ArrayPieceSquadro
$arrayPieceSquadro = new ArrayPieceSquadro();
$arrayPieceSquadro->add($pieceVide);
$arrayPieceSquadro->add($pieceNeutre);
$arrayPieceSquadro->add($pieceNoirNord);
$arrayPieceSquadro->add($pieceBlancEst);

// Conversion en JSON
$jsonArray = $arrayPieceSquadro->toJson();

// Création d'une instance à partir d'une chaîne JSON
$arrayFromJson = ArrayPieceSquadro::fromJson($jsonArray);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test ArrayPieceSquadro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .piece {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .json {
            font-family: monospace;
            background-color: #f9f9f9;
            padding: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Test ArrayPieceSquadro</h1>

    <div class="piece">
        <div class="title">Initialisation des objets:</div>
        <div><?php echo $pieceVide; ?></div>
        <div><?php echo $pieceNeutre; ?></div>
        <div><?php echo $pieceNoirNord; ?></div>
        <div><?php echo $pieceBlancEst; ?></div>
    </div>

    <div class="piece">
        <div class="title">Contenu de ArrayPieceSquadro:</div>
        <div><?php echo $arrayPieceSquadro; ?></div>
    </div>

    <div class="piece">
        <div class="title">Conversion en JSON:</div>
        <div class="json"><?php echo $jsonArray; ?></div>
    </div>

    <div class="piece">
        <div class="title">Création d'une instance à partir d'une chaîne JSON:</div>
        <div><?php echo $arrayFromJson; ?></div>
    </div>
</body>
</html>
