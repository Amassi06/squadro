<?php
session_start();

require_once "../model/PlateauSquadro.php";
require_once "../model/ActionSquadro.php";
require_once '../view/PieceSquadroUI.php';

//Passer son tour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_joueur_actuel'])) {
    $_SESSION['jouer_actual'] = ($_SESSION['jouer_actual'] === 'blancs') ? 'noires' : 'blancs';
    header("Location: ../view/index.php");
    exit();
}

// Vérification de la requête GET

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['x'], $_GET['y'], $_GET['v'])) {
    $x = htmlspecialchars($_GET['x']);
    $y = htmlspecialchars($_GET['y']);
    $v = htmlspecialchars($_GET['v']);

    // Initialisation des sessions avec coalescence nulle (évite les conditions if/else)
    $_SESSION['score'] = $_SESSION['score'] ?? [0, 0];
    $_SESSION['jouer_actual'] = $_SESSION['jouer_actual'] ?? "blancs";
    $_SESSION['etat_jeux'] = $_SESSION['etat_jeux'] ?? (new PlateauSquadro())->toJson();

    // Chargement des données de session
    $score = &$_SESSION['score'];
    $jouer_actual = &$_SESSION['jouer_actual'];
    $plateau = PlateauSquadro::fromJson(($_SESSION['etat_jeux']));

    // Changement du joueur actuel
    $jouer_actual = ($jouer_actual === "blancs") ? "noires" : "blancs";

    // Création de l'objet ActionSquadro et exécution du coup
    $action = new ActionSquadro($plateau);
    $action->jouePiece($x, $y, $v, $jouer_actual === 'blancs' ? PieceSquadro::BLANC : PieceSquadro::NOIR);

    // Mise à jour du score
    $score[0] = 5 - count(array_filter($plateau->getLignesJouables(), function($value) {
        return $value !== null;
    }));
    
    $score[1] = 5 - count(array_filter($plateau->getColonnesJouables(), function($value) {
        return $value !== null;
    }));
    


    // Sauvegarde dans la session
    $_SESSION['etat_jeux'] = $plateau->toJson();

    // Redirection immédiate vers la page principale
    header("Location: ../view/index.php");
    exit();
}
