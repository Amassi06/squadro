<?php

/**
 * Class PieceSquadro
 * Représente une pièce du jeu Squadro avec une couleur et une direction (optionnelle).
 */
class PieceSquadro {
    // Constantes pour les couleurs
    public const BLANC = 0;
    public const NOIR = 1;
    public const VIDE = -1;
    public const NEUTRE = -2;

    // Constantes pour les directions
    public const NORD = 0;
    public const EST = 1;
    public const SUD = 2;
    public const OUEST = 3;

    // Propriétés protégées
    protected int $couleur;
    protected int $direction;

    /**
     * Constructeur privé
     *
     * @param int $couleur La couleur de la pièce.
     * @param int|null $direction La direction de la pièce (optionnelle).
     */
    private function __construct(int $couleur, ?int $direction = null) {
        $this->couleur = $couleur;
        $this->direction = $direction ?? self::NEUTRE;
    }

    /**
     * Accesseur pour la couleur.
     *
     * @return int La couleur de la pièce.
     */
    public function getCouleur(): int {
        return $this->couleur;
    }

    public function  setCouleur(int $c):void{
        $this->couleur = $c;
    }

    /**
     * Accesseur pour la direction.
     *
     * @return int La direction de la pièce.
     */
    public function getDirection(): int {
        return $this->direction;
    }

    public function  setDirection(int $d):void{
        $this->direction = $d;
    }

    /**
     * Inverse la direction de la pièce.
     *
     * @return void
     */
    public function inverseDirection(): void {
        switch ($this->direction) {
            case self::NORD:
                $this->direction = self::SUD;
                break;
            case self::SUD:
                $this->direction = self::NORD;
                break;
            case self::EST:
                $this->direction = self::OUEST;
                break;
            case self::OUEST:
                $this->direction = self::EST;
                break;
        }
    }

    /**
     * Convertit l'objet PieceSquadro en une représentation JSON.
     *
     * @return string Chaîne JSON représentant l'objet PieceSquadro.
     */
    public function toJson(): string {
        return json_encode([
            'couleur' => $this->couleur,
            'direction' => $this->direction,
        ]);
    }

    /**
     * Recrée un objet PieceSquadro à partir de sa représentation JSON.
     *
     * @param string $json Chaîne JSON représentant un objet PieceSquadro.
     * @return PieceSquadro L'objet PieceSquadro reconstruit.
     */
    public static function fromJson(string $json): PieceSquadro {
        $data = json_decode($json, true);
        return new self($data['couleur'], $data['direction'] ?? self::NEUTRE);
    }

    /**
     * Crée une instance prédéfinie avec la couleur VIDE.
     *
     * @return PieceSquadro L'instance créée.
     */
    public static function initVide(): PieceSquadro {
        return new self(self::VIDE);
    }

    /**
     * Crée une instance prédéfinie avec la couleur NEUTRE.
     *
     * @return PieceSquadro L'instance créée.
     */
    public static function initNeutre(): PieceSquadro {
        return new self(self::NEUTRE);
    }

    /**
     * Crée une instance prédéfinie avec la couleur NOIR et la direction NORD.
     *
     * @return PieceSquadro L'instance créée.
     */
    public static function initNoirNord(): PieceSquadro {
        return new self(self::NOIR, self::NORD);
    }

     /**
     * Crée une instance prédéfinie avec la couleur NOIR et la direction SUD.
     *
     * @return PieceSquadro L'instance créée.
     */
    public static function initNoirSud(): PieceSquadro {
        return new self(self::NOIR, self::SUD);
    }

    /**
     * Crée une instance prédéfinie avec la couleur BLANC et la direction EST.
     *
     * @return PieceSquadro L'instance créée.
     */
    public static function initBlancEst(): PieceSquadro {
        return new self(self::BLANC, self::EST);
    }
    
    /**
     * Crée une instance prédéfinie avec la couleur BLANC et la direction OUEST.
     *
     * @return PieceSquadro L'instance créée.
     */
    public static function initBlancOuest(): PieceSquadro {
        return new self(self::BLANC, self::OUEST);
    }
    /**
     * Affiche l'objet en chaîne.
     *
     * @return string La représentation en chaîne de l'objet.
     */
    public function __toString(): string {
        return "Couleur: $this->couleur, Direction: $this->direction";
    }
}
