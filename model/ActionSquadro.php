<?php
require_once "PlateauSquadro.php";

class ActionSquadro
{
    // Propriété pour le plateau de jeu
    private PlateauSquadro $plateau;

    // Constructeur
    public function __construct(PlateauSquadro $p)
    {
        $this->plateau = $p;
    }

    // Vérifie si une pièce peut être jouée
    public function estJouablePiece(int $x, int $y): bool
    {
        $piece = $this->plateau->getPiece($x, $y);
        if (!$piece instanceof PieceSquadro || $piece->getCouleur() === PieceSquadro::VIDE || $piece->getCouleur() === PieceSquadro::NEUTRE)
            return false; // Pas de pièce ou case vide ou neutre
        return true;
    }

    public function jouePiece(int $x, int $y, int $v, int $jouer_actual): void
    {
        $piece = $this->plateau->getPiece($x, $y);

        if ($jouer_actual === PieceSquadro::BLANC) {

            if ($piece->getDirection() === PieceSquadro::NORD) {
                $newX = $x - $v;
                for ($i = $x - 1; $i > $newX; $i--) {

                    $pieceSurChemin = $this->plateau->getPiece($i, $y);

                    if ($pieceSurChemin->getCouleur() === PieceSquadro::BLANC) {
                        $this->retournerPieceAuDepart($i, $y);
                    }
                }

                if ($newX >= 1) {
                    $this->plateau->getPiece($x - $v, $y)->setDirection(PieceSquadro::NORD);
                    $this->plateau->getPiece($x - $v, $y)->setCouleur(PieceSquadro::NOIR);
                } else {
                    $this->plateau->getPiece(0, $y)->setDirection(PieceSquadro::SUD);
                    $this->plateau->getPiece(0, $y)->setCouleur(PieceSquadro::NOIR);
                }
            } else {
                $newX = $x + $v;
                for ($i = $x + 1; $i < $newX; $i++) {

                    $pieceSurChemin = $this->plateau->getPiece($i, $y);

                    // Si cette case contient une pièce noire (par exemple couleur == 0)
                    if ($pieceSurChemin->getCouleur() === PieceSquadro::BLANC) {
                        // Retourne la pièce noire à sa position initiale
                        $this->retournerPieceAuDepart($i, $y);
                    }
                }
                if ($newX <= 5) {
                    $this->plateau->getPiece($x + $v, $y)->setDirection(PieceSquadro::SUD);
                    $this->plateau->getPiece($x + $v, $y)->setCouleur(PieceSquadro::NOIR);
                } else {
                    $this->plateau->retireColonneJouable($y);
                }
            }


        } else {

            if ($piece->getDirection() === PieceSquadro::EST) {
                $newY = $y + $v;

                for ($i = $y + 1; $i < $newY; $i++) {

                    $pieceSurChemin = $this->plateau->getPiece($x, $i);

                    // Si cette case contient une pièce noire (par exemple couleur == 0)
                    if ($pieceSurChemin->getCouleur() === PieceSquadro::NOIR) {
                        // Retourne la pièce noire à sa position initiale
                        $this->retournerPieceAuDepart($x, $i);
                    }
                }


                if ($newY <= 5) {
                    $this->plateau->getPiece($x, $y + $v)->setDirection(PieceSquadro::EST);
                    $this->plateau->getPiece($x, $y + $v)->setCouleur(PieceSquadro::BLANC);
                } else {
                    $this->plateau->getPiece($x, 6)->setDirection(PieceSquadro::OUEST);
                    $this->plateau->getPiece($x, 6)->setCouleur(PieceSquadro::BLANC);
                }
            } else {
                $newY = $y - $v;
                for ($i = $y - 1; $i > $newY; $i--) {

                    $pieceSurChemin = $this->plateau->getPiece($x, $i);

                    // Si cette case contient une pièce noire (par exemple couleur == 0)
                    if ($pieceSurChemin->getCouleur() === PieceSquadro::EST) {
                        // Retourne la pièce noire à sa position initiale
                        $this->retournerPieceAuDepart($x, $i);
                    }
                }
                if ($newY >= 1) {
                    $this->plateau->getPiece($x, $y - $v)->setDirection(PieceSquadro::OUEST);
                    $this->plateau->getPiece($x, $y - $v)->setCouleur(PieceSquadro::BLANC);
                } else {
                    $this->plateau->retireLigneJouable($x);
                }
            }
        }
        $piece->setCouleur(PieceSquadro::VIDE);
        $piece->setDirection(PieceSquadro::NEUTRE);
    }

    public function retournerPieceAuDepart(int $x, int $y):void
    {
        // Récupère la pièce située à la position actuelle
        $piece = $this->plateau->getPiece($x, $y);

        if ($piece->getDirection() == PieceSquadro::NORD) {
            $this->plateau->getPiece(6, $y)->setDirection(PieceSquadro::NORD);
            $this->plateau->getPiece(6, $y)->setCouleur(PieceSquadro::NOIR);
        } elseif ($piece->getDirection() == PieceSquadro::SUD) {
            $this->plateau->getPiece(0, $y)->setDirection(PieceSquadro::SUD);
            $this->plateau->getPiece(0, $y)->setCouleur(PieceSquadro::NOIR);
        } elseif ($piece->getDirection() == PieceSquadro::EST) {
            // Pour une pièce venant de la gauche, sa case de départ est [$x][0]
            $this->plateau->getPiece($x, 0)->setDirection(PieceSquadro::EST);
            $this->plateau->getPiece($x, 0)->setCouleur(PieceSquadro::BLANC);
        } elseif ($piece->getDirection() == PieceSquadro::OUEST) {
            // Pour une pièce venant de la droite, sa case de départ est [$x][6]
            $this->plateau->getPiece($x, 6)->setDirection(PieceSquadro::OUEST);
            $this->plateau->getPiece($x, 6)->setCouleur(PieceSquadro::BLANC);
        }

        // Enfin, on vide la case actuelle en affectant des valeurs indiquant l'absence de pièce.
        $piece->setCouleur(PieceSquadro::VIDE);
        $piece->setDirection(PieceSquadro::NEUTRE);
    }
}
