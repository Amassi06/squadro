<?php

require_once 'PieceSquadro.php'; // Chargez votre classe PieceSquadro

// Initialisation des objets
$pieceVide = PieceSquadro::initVide();
$pieceNeutre = PieceSquadro::initNeutre();
$pieceNoirNord = PieceSquadro::initNoirNord();
$pieceBlancEst = PieceSquadro::initBlancEst();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test PieceSquadro</title>
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
    <h1>Test PieceSquadro</h1>

    <div class="piece">
        <div class="title">Initialisation des objets:</div>
        <div><?php echo $pieceVide; ?></div>
        <div><?php echo $pieceNeutre; ?></div>
        <div><?php echo $pieceNoirNord; ?></div>
        <div><?php echo $pieceBlancEst; ?></div>
    </div>

    <div class="piece">
        <div class="title">Utilisation des accesseurs:</div>
        <div>Couleur de pieceNoirNord: <?php echo $pieceNoirNord->getCouleur(); ?></div>
        <div>Direction de pieceNoirNord: <?php echo $pieceNoirNord->getDirection(); ?></div>
    </div>

    <div class="piece">
        <div class="title">Inversion de la direction:</div>
        <?php $pieceNoirNord->inverseDirection(); ?>
        <div>Direction inversée de pieceNoirNord: <?php echo $pieceNoirNord->getDirection(); ?></div>
    </div>

    <div class="piece">
        <div class="title">Conversion en JSON:</div>
        <div class="json"><?php echo $pieceBlancEst->toJson(); ?></div>
    </div>

    <div class="piece">
        <div class="title">Création d'une instance à partir d'une chaîne JSON:</div>
        <?php $pieceFromJson = PieceSquadro::fromJson($pieceBlancEst->toJson()); ?>
        <div>Instance créée à partir du JSON: <?php echo $pieceFromJson; ?></div>
    </div>

    <div class="piece">
        <div class="title">Affichage de l'objet en chaîne:</div>
        <div><?php echo $pieceFromJson->__toString(); ?></div>
    </div>
</body>
</html>
