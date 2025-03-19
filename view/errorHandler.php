<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


error_reporting(E_ALL);
ini_set('display_errors', 1);

// Définir un gestionnaire d'erreurs personnalisé
function gestionnaireErreurs($errno, $errstr, $errfile, $errline): void {
    // Stocker les informations d'erreur dans la session
    $_SESSION['error'] = [
        'type' => 'Erreur PHP',
        'errno' => $errno,
        'errstr' => $errstr,
        'errfile' => $errfile,
        'errline' => $errline
    ];

    // Rediriger vers errorPage.php
    header("Location: errorPage.php");
    exit();
}

// Enregistrer la fonction gestionnaire d'erreurs
set_error_handler("gestionnaireErreurs");

// Gestion des exceptions
function gestionnaireExceptions($exception): void {
    // Stocker les informations de l'exception dans la session
    $_SESSION['error'] = [
        'type' => 'Exception',
        'message' => $exception->getMessage(),
        'file' => $exception->getFile(),
        'line' => $exception->getLine()
    ];

    // Rediriger vers error.php
    header("Location: errorPage.php");
    exit();
}

// Enregistrer la fonction gestionnaire d'exceptions
set_exception_handler("gestionnaireExceptions");

register_shutdown_function(function() {
    $error = error_get_last();
    if ($error !== null) {
        $_SESSION['error'] = [
            'type' => 'Erreur Fatale',
            'message' => $error['message'],
            'file' => $error['file'],
            'line' => $error['line']
        ];
        header("Location: errorPage.php");
        exit();
    }
});


