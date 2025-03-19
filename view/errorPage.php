<?php
if (session_status() == PHP_SESSION_NONE) {session_start();}
// Vérifier si une erreur a été stockée dans la session
if (isset($_SESSION['error'])) {
    // Récupérer les informations d'erreur
    $error = $_SESSION['error'];
    $type = $error['type'];
    $message = $error['errstr'] ?? $error['message'];
    $file = $error['errfile'] ?? $error['file'];
    $line = $error['errline'] ?? $error['line'];

    // Supprimer l'erreur de la session après l'affichage
} else {
    // Si aucune erreur n'a été stockée
    echo "<h1>Aucune erreur n'a été détectée.</h1>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur - <?= $type ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .error-container {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 60%;
            max-width: 800px;
            text-align: left;
        }
        h1 {
            color: #e74c3c;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
        }
        .error-details {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 5px solid #e74c3c;
        }
        .error-details span {
            font-weight: bold;
        }

        .btn-rejouer {
            display: inline-block;
            background-color: #28a745; /* Vert */
            color: white;
            margin: 12px;
            padding: 12px 24px;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .btn-rejouer:hover {
            background-color: #218838; /* Vert plus foncé */
            transform: scale(1.05); /* Légère augmentation de la taille */
        }
        .btn-rejouer:active {
            background-color: #1e7e34; /* Vert encore plus foncé lors du clic */
            transform: scale(1); /* Retour à la taille initiale */
        }
    </style>
</head>
<body>

<div class="error-container">
    <h1><?= $type ?> - Quelque chose a mal tourné</h1>
    <p>Une erreur est survenue lors de l'exécution de la page. Veuillez trouver les détails ci-dessous :</p>

    <div class="error-details">
        <p><span>Message : </span><?= htmlspecialchars($message) ?></p>
        <p><span>Fichier : </span><?= htmlspecialchars($file) ?></p>
        <p><span>Ligne : </span><?= htmlspecialchars($line) ?></p>
    </div>

    <!-- Ajout du bouton "Rejouer" pour revenir à l'index -->
    <a href="index.php" class="btn-rejouer">Rejouer</a>

</div>

</body>
</html>
