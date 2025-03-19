<?php

/**
 * Class PieceSquadroUI
 * Génère le code HTML pour les différentes pièces et cases du jeu Squadro.
 */
require_once('../model/PlateauSquadro.php');

class PieceSquadroUI
{
    /**
     * @var PlateauSquadro Instance de PlateauSquadro.
     */
    private PlateauSquadro $plateauSquadro;

    /**
     * Constructeur de la classe PieceSquadroUI.
     */
    public function __construct()
    {
        $this->plateauSquadro = new PlateauSquadro();
    }

    /**
     * Retourne l'objet PlateauSquadro.
     *
     * @return PlateauSquadro L'objet PlateauSquadro.
     */
    public function getPlateauObject():PlateauSquadro
    {
        return $this->plateauSquadro;
    }

    /**
     * Génère le code HTML pour une case vide.
     *
     * @return string Le code HTML d'une case vide.
     */
    public function genererCaseVide(): string
    {
        return "<button class='btn-gray-light'></button>";
    }

    /**
     * Génère le code HTML pour une case neutre.
     *
     * @return string Le code HTML d'une case neutre.
     */
    public function genererCaseNeutre(): string
    {
        return "<button class='btn-gray'></button>";
    }

    /**
     * Génère le code HTML pour une pièce blanche.
     *
     * @param int $direction La direction de la pièce (par exemple, "BE" ou "BO").
     * @param int $x La position x de la pièce.
     * @param int $y La position y de la pièce.
     * @return string Le code HTML d'une pièce blanche.
     * @throws InvalidArgumentException Si la direction est invalide.
     */
    public function genererPieceBlanche(int $direction, int $x, int $y): string
    {

        $vOuest = [1, 3, 2, 3, 1];
        $vEst = [3, 1, 2, 1, 3];
        if (!in_array($direction, [PieceSquadro::OUEST, PieceSquadro::EST])) {
            throw new InvalidArgumentException("Direction invalide : $direction");
        }

        if ($direction === PieceSquadro::OUEST) {
            $cls = "btn-left";
            $v = $vEst[$x - 1];
        } else {
            $cls = "btn-right";
            $v = $vOuest[$x - 1];
        }

        return "<form method='GET' action='../controller/traiteActionSquadro.php'>
             <input type='hidden' name='x' value='$x'>
             <input type='hidden' name='y' value='$y'>
              <input type='hidden' name='v' value='$v'>
             <button class='btn-white $cls' type='submit'></button>
         </form>";
    }

    /**
     * Génère le code HTML pour une pièce noire.
     *
     * @param int $direction La direction de la pièce (par exemple, "NN" ou "NS").
     * @param int $x La position x de la pièce.
     * @param int $y La position y de la pièce.
     * @return string Le code HTML d'une pièce noire.
     * @throws InvalidArgumentException Si la direction est invalide.
     */
    public function genererPieceNoire(int $direction, int $x, int $y): string
    {
        if (!in_array($direction, [PieceSquadro::SUD, PieceSquadro::NORD])) {
            throw new InvalidArgumentException("Direction invalide : $direction");
        }

        $vNord = [1, 3, 2, 3, 1];
        $vSud = [3, 1, 2, 1, 3];

        if ($direction === PieceSquadro::SUD) {
            $cls = "btn-down";
            $v = $vNord[$y - 1];
        } else {
            $cls = "btn-up";
            $v = $vSud[$y - 1];
        }

        return "<form method='GET' action='../controller/traiteActionSquadro.php' >
             <input type='hidden' name='x' value='$x'>
             <input type='hidden' name='y' value='$y'>
               <input type='hidden' name='v' value='$v'>
             <button class='btn-black $cls' type='submit'></button>
         </form>";
    }

    /**
     * Génère le code HTML pour un bouton rouge.
     *
     * @param string|null $text Le texte à afficher sur le bouton (optionnel).
     * @return string Le code HTML du bouton rouge.
     */
    public function genererBoutonRouge(?string $text = null): string
    {
        if ($text !== null && in_array($text, ["1", "2", "3"], true)) {
            return "<button class='btn-red'><span class='circle'>" . htmlspecialchars($text) . "</span></button>";
        }
        return "<button class='btn-red'></button>";
    }

    /**
     * Génère la périphérie rouge avec les chiffres successifs pour les cases de 3 à 7.
     *
     * @param int $i La position i de la case.
     * @param int $j La position j de la case.
     * @return string Le code HTML de la case périphérique rouge.
     */
    public function genererPeripheriqueRouge(int $i, int $j): string
    {
        $sequenceHaut = [1, 3, 2, 3, 1];
        $sequenceBas = [3, 1, 2, 1, 3];

        if ($i == -1 || $i == 7) {
            $sequence = ($i == -1) ? $sequenceHaut : $sequenceBas;
            if ($j >= 1 && $j <= 5) {
                $index = $j - 1;
                $text = $sequence[$index];
                return $this->genererBoutonRouge($text);
            }
        }

        if ($j == -1 || $j == 7) {
            $sequence = ($j == -1) ? $sequenceHaut : $sequenceBas;
            if ($i >= 1 && $i <= 5) {
                $index = $i - 1;
                $text = $sequence[$index];
                return $this->genererBoutonRouge($text);
            }
        }

        return $this->genererBoutonRouge('');
    }



    public function desactiverBoutons($classe): string
    {
       
        return "
        <script>
            window.onload = function() {
                desactiverBoutons('$classe');  // Appel de la fonction avec la classe du bouton (par ex. 'btn-black')
            };
        </script>";
    }






    /**
     * Initialise le jeu avec les pièces sur le plateau.
     *
     * @param PlateauSquadro $plateauSquadro L'objet PlateauSquadro.
     * @return string Le code HTML du plateau de jeu initialisé.
     */
    public function initJeux(PlateauSquadro $plateauSquadro,String $jouer_actual ): string
    {
        $html = '<div class="columns">';
        for ($i = -1; $i < 8; $i++) {
            $html .= '<div class="column">';
            for ($j = -1; $j < 8; $j++) {
                if ($i == -1 || $i == 7 || $j == -1 || $j == 7) {
                    $html .= $this->genererPeripheriqueRouge($i, $j);
                } else {
                    $piece = $plateauSquadro->getPlateau()[$j]->offsetGet($i);
                    $pieceC = $piece->getCouleur();
                    $dir = $piece->getDirection();
                    switch ($pieceC) {
                        case PieceSquadro::BLANC:
                            $html .= $this->genererPieceBlanche($dir, $j, $i);
                            break;
                        case PieceSquadro::NOIR:
                            $html .= $this->genererPieceNoire($dir, $j, $i);
                            break;
                        case PieceSquadro::NEUTRE:
                            $html .= $this->genererCaseNeutre();
                            break;
                        case PieceSquadro::VIDE:
                            $html .= $this->genererCaseVide();
                            break;
                    }
                }
            }

            $html .= '</div>';
        }
        $html .= '</div>';

        $classe = "";

        if($jouer_actual === "blancs"){$classe = "btn-black"; }else{$classe = "btn-white";}

        $html .= $this->desactiverBoutons($classe);

        return $html;
    }
}
