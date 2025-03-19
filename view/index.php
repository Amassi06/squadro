<?php
session_start();
// Inclusion des classes nécessaires
require_once 'PieceSquadroUI.php';
require_once '../model/PlateauSquadro.php';
require_once 'errorHandler.php';

// Création d'une instance de la classe
$pieceSquadroUI = new PieceSquadroUI();

// Initialisation des variables de session avec coalescence nulle
$_SESSION['score'] = $_SESSION['score'] ?? [0, 0];
$_SESSION['jouer_actual'] = $_SESSION['jouer_actual'] ?? "blancs";

// Gestion de l'état du jeu (plateau)
if (!isset($_SESSION['etat_jeux'])) {
    $_SESSION['etat_jeux'] = $pieceSquadroUI->getPlateauObject()->toJson();
}

$plateau = PlateauSquadro::fromJson($_SESSION['etat_jeux']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Squadro Game</title>
    <!-- Inclusion du fichier CSS -->
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<!-- Particles.js Background -->
<div id="particles-js"></div>

<div class="game-container">
    <div class="game-header">
        <div class="game-title">Squadro</div>
        <div class="game-status <?php echo ($_SESSION['jouer_actual'] === 'blancs') ? 'blancs' : 'noirs'; ?>">
            Les <?= htmlspecialchars($_SESSION['jouer_actual']); ?> jouent
        </div>
    </div>

    <div class="score-container">
        <p class="score"><span class="white">Blancs</span> : <?php echo $_SESSION['score'][0]; ?>
            <span class="black">Noirs</span> : <?php echo $_SESSION['score'][1]; ?> </p>
    </div>

    <form method="POST" action="../controller/traiteActionSquadro.php">
        <input type="hidden" name="form_joueur_actuel" value="<?php echo $_SESSION['jouer_actual'] ?>">
        <button class="btn-passer" type="submit">Passer son tour</button>
    </form>

    <script src="./script/confetti.js"></script>
    <script src="./script/sweetalert.js"></script>
    <script src="./script/particles.js"></script>
    <script src="./script/script.js"></script>
<div class="grille">
    <?php
    // Initialisation du jeu
    echo $pieceSquadroUI->initJeux($plateau, $_SESSION['jouer_actual']);

    // Gestion victoire
    if ($_SESSION['score'][0] === 4) { // Blanche
        echo "<script>afficherVictoireSquadro(" . PieceSquadro::BLANC . ")</script>";
        session_destroy();
    } elseif ($_SESSION['score'][1] === 4) { //Noir
        echo "<script>afficherVictoireSquadro(" . PieceSquadro::NOIR . ")</script>";
        session_destroy();
    }
    ?>
</div>
</div>

</body>
</html>
