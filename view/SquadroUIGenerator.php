<?php

require_once 'PieceSquadroUI.php';

class SquadroUIGenerator {

    private $pieceSquadroUI;

    public function __construct() {
        $this->pieceSquadroUI = new PieceSquadroUI();
    }

    /**
     * Génère le HTML du plateau de jeu en utilisant la classe PieceSquadroUI.
     *
     * @return string Le code HTML du plateau de jeu.
     */
    public function genererPlateauJeu($joueur): string {
        $html = '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Test de la classe PieceSquadroUI</title>
            <!-- Inclusion du fichier CSS -->
            <link rel="stylesheet" href="./css/style.css">
            <script src="./script/script.js"></script>
        </head>
        <body>
        
        <div class="game-header">
            <div class="game-title">Squadro</div>
            <div class="game-status">Les '; 
        $html .= $joueur.' ';
        $html .= 'jouent</div></div>';

        $html .= '<div class="columns">';
        for ($i = 0; $i < 9; $i++) {
            $html .= '<div class="column">';
            for ($j = 0; $j < 9; $j++) {
                // Vérifier si c'est une case périphérique
                if ($i == 0 || $i == 8 || $j == 0 || $j == 8) {
                    // Utiliser la méthode de la classe PieceSquadroUI pour générer la périphérie rouge
                    $html .= $this->pieceSquadroUI->genererPeripheriqueRouge($i, $j);
                }
                // Vérifier si c'est un coin interne
                elseif (($i == 1 && $j == 1) || ($i == 1 && $j == 7) || ($i == 7 && $j == 1) || ($i == 7 && $j == 7)) {
                    // Utiliser la méthode de la classe PieceSquadroUI pour générer une case neutre
                    $html .= $this->pieceSquadroUI->genererCaseNeutre();
                }
                // Vérifier si c'est la 2e colonne (colonne 1)
                elseif ($i == 1) {
                    // Utiliser la méthode de la classe PieceSquadroUI pour générer une pièce blanche
                    $html .= $this->pieceSquadroUI->genererPieceBlanche('BE', $i, $j);
                }
                // Vérifier si c'est l'avant-dernière ligne (ligne 7)
                elseif ($j == 7) {
                    // Utiliser la méthode de la classe PieceSquadroUI pour générer une pièce noire
                    $html .= $this->pieceSquadroUI->genererPieceNoire('NN', $i, $j);
                }
                else {
                    // Utiliser la méthode de la classe PieceSquadroUI pour générer une case vide
                    $html .= $this->pieceSquadroUI->genererCaseVide();
                }
            }
            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '</body>
        </html>';

        if ($joueur === "blancs") {
            $html .= $this->pieceSquadroUI->desactiverBoutons('btn-black');
        } else {
            $html .= $this->pieceSquadroUI->desactiverBoutons('btn-white');
        }

        return $html;
    }

    /**
     * Génère la page de confirmation pour le déplacement d'une pièce.
     *
     * @return string Le code HTML de la page de confirmation.
     */

     public function genererPageConfirmation($distance, $direction): string {
        $html = "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Confirmer votre action ?</title>
            <link rel='stylesheet' href='./css/style.css'>
        </head>
        <body>
            <div class='container'>
                <h1>Confirmer votre action ? </h1>
                <p>
                    Êtes-vous sûr de vouloir déplacer la pièce de <span class='highlight'>$distance</span> position vers le <span class='highlight'>$direction</span> ?
                </p>
                <div class='buttons'>
                    <form action='confirmer_deplacement.php' method='POST'>
                        <input type='hidden' name='distance' value='$distance'>
                        <input type='hidden' name='direction' value='$direction'>
                        <button type='submit' class='btn-confirm'>Confirmer</button>
                    </form>
                    <button class='btn-cancel' onclick='window.history.back()'>Annuler</button>
                </div>
            </div>
        </body>
        </html>
        ";
    
        return $html;
    }


  
    
    public function genererPageVictoire($gagnant): string {
        $html = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Victoire de ' . $gagnant . '</title>
            <link rel="stylesheet" href="./css/style.css"> <!-- Inclure le fichier CSS -->
        </head>
        <body>

        <div class="container" style="margin-top:5%">
                <p><span class="highlight">' . $gagnant . '</span> ont gagné la partie !</p>
                <div class="buttons">
                    <button class="btn-confirm" onclick="window.location.reload();">Rejouer</button>
                    <button class="btn-cancel" onclick="window.location.href=\'./index.html\';">Retour à l\'accueil</button>
                </div>
            </div>
            
            
            <!-- Plateau de jeu -->
            <div class="columns">
        ';
    
        for ($i = 0; $i < 9; $i++) {
            $html .= '<div class="column">';
            for ($j = 0; $j < 9; $j++) {
                // Vérifier si c'est une case périphérique
                if ($i == 0 || $i == 8 || $j == 0 || $j == 8) {
                    $html .= $this->pieceSquadroUI->genererPeripheriqueRouge($i, $j);
                }
                // Vérifier si c'est un coin interne
                elseif (($i == 1 && $j == 1) || ($i == 1 && $j == 7) || ($i == 7 && $j == 1) || ($i == 7 && $j == 7)) {
                    $html .= $this->pieceSquadroUI->genererCaseNeutre();
                }
                // Vérifier si c'est la 2e colonne (colonne 1)
                elseif ($i == 1) {
                    $html .= $this->pieceSquadroUI->genererPieceBlanche('BE', $i, $j);
                }
                // Vérifier si c'est l'avant-dernière ligne (ligne 7)
                elseif ($j == 7) {
                    $html .= $this->pieceSquadroUI->genererPieceNoire('NN', $i, $j);
                }
                else {
                    $html .= $this->pieceSquadroUI->genererCaseVide();
                }
            }
            $html .= '</div>';
        }
    
        $html .= '</div>';
    
        // Ajouter les boutons Rejouer et Retour à l'Accueil
        $html .= '
        </body>
        </html>';
    
        return $html;
    }
    
    

   }
?>
