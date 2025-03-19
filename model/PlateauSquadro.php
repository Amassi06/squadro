<?php
require_once "ArrayPieceSquadro.php";
require_once "PieceSquadro.php";

class PlateauSquadro
{
    // Constantes
    public const  BLANC_V_ALLER = [0, 1, 3, 2, 3, 1, 0];
    public const  BLANC_V_RETOUR = [0, 3, 1, 2, 1, 3, 0];
    public const  NOIR_V_ALLER = [0, 3, 1, 2, 1, 3, 0];
    public const  NOIR_V_RETOUR = [0, 1, 3, 2, 3, 1, 0];

    // Variables d'instance
    private  $plateau = [];
    private  $lignesJouables = [1, 2, 3, 4, 5];
    private  $colonnesJouables = [1, 2, 3, 4, 5];
    /**
     * Constructeur qui initialise les lignes du plateau avec des objets ArrayPieceSquadro.
     */
    public function __construct()
    {
        // Initialiser les 7 lignes du plateau avec des objets ArrayPieceSquadro
        for ($i = 0; $i < 7; $i++) {
            $this->plateau[$i] = new ArrayPieceSquadro();
        }
        $this->initCasesVides();
        $this->initCasesNeutres();
        $this->initCasesBlanches();
        $this->initCasesNoires();
    }

    /**
     * Initialise les cases vides du plateau, à l'exception de la case [6, 0].
     */
    private function initCasesVides(): void
    {
        for ($i = 0; $i < 6; $i++) {
            for ($j = 1; $j < 7; $j++) {
                if ($i == 0 && $j == 6) continue; // case neutre
                $this->plateau[$i]->offsetSet($j, PieceSquadro::initVide());
            }
        }
    }
    /**
     * Initialise les cases neutres aux coordonnées spécifiques.
     */
    private function initCasesNeutres(): void
    {
        $cases = [[0, 0], [0, 6], [6, 0], [6, 6]];
        foreach ($cases as $case)
            $this->plateau[$case[0]]->offsetSet($case[1], PieceSquadro::initNeutre());
    }
    /**
     * Initialise les cases blanches selon les lignes jouables.
     */
    private function initCasesBlanches(): void
    {
        foreach ($this->lignesJouables as $lig) {
            $this->plateau[$lig]->offsetSet(0, PieceSquadro::initBlancEst());
        }
    }
    /**
     * Initialise les cases noires selon les colonnes jouables.
     */
    private function initCasesNoires(): void
    {
        foreach ($this->colonnesJouables as $col)
            $this->plateau[6]->offsetSet($col, PieceSquadro::initNoirNord());
    }

    /**
     * Récupère l'état actuel du plateau.
     *
     * @return ArrayPieceSquadro[] Le plateau de jeu.
     */
    public function getPlateau(): array
    {
        return $this->plateau;
    }
    /**
     * Récupère la pièce à une position donnée sur le plateau.
     *
     * @param int $x L'index de la ligne.
     * @param int $y L'index de la colonne.
     * @return PieceSquadro|null La pièce à la position donnée ou null si vide.
     */
    public function getPiece(int $x, int $y): ?PieceSquadro
    {
        return $this->plateau[$x]->offsetGet($y) ?? null;
    }
    /**
     * Place une pièce à une position spécifique sur le plateau.
     *
     * @param PieceSquadro $piece La pièce à placer.
     * @param int $x L'index de la ligne.
     * @param int $y L'index de la colonne.
     */
    public function setPiece(PieceSquadro $piece, int $x, int $y): void
    {
        $piece->setCouleur(PieceSquadro::VIDE);
        $this->plateau[$x]->offsetSet($y, $piece);
    }
    /**
     * Récupère les lignes jouables actuelles.
     *
     * @return int[] Les lignes jouables.
     */
    public function getLignesJouables(): array
    {
        return $this->lignesJouables;
    }
    /**
     * Récupère les colonnes jouables actuelles.
     *
     * @return int[] Les colonnes jouables.
     */
    public function getColonnesJouables(): array
    {
        return $this->colonnesJouables;
    }
    /**
     * Retire une valeur du tableau $lignesJouables en la remplaçant par null
     *
     * @param int $ligne La valeur à retirer
     */
    public function retireLigneJouable($ligne) {
        // Cherche l'index de la valeur dans le tableau
        $index = array_search($ligne, $this->lignesJouables);
        if ($index !== false) {
            // Remplace la valeur trouvée par null
            $this->lignesJouables[$index] = null;
        }
    }

    /**
     * Retire une valeur du tableau $colonnesJouables en la remplaçant par null
     *
     * @param int $colonne La valeur à retirer
     */
    public function retireColonneJouable($colonne) {
        // Cherche l'index de la valeur dans le tableau
        $index = array_search($colonne, $this->colonnesJouables);
        if ($index !== false) {
            // Remplace la valeur trouvée par null
            $this->colonnesJouables[$index] = null;
        }
    }
    /**
     * Récupère les coordonnées de destination pour un mouvement donné.
     *
     * @param int $x L'index de la ligne de départ.
     * @param int $y L'index de la colonne de départ.
     * @return array Les coordonnées de destination sous forme de tableau [x, y].
     */
    public function getCoordDestination(int $x, int $y): array
    {
        if (!$this->plateau[$x]->offsetExists($y))
            throw new InvalidArgumentException("Il n'existe pas de pièce Squadro à la position ($x, $y).");

        $piece = $this->getPiece($x, $y);

        if ($piece instanceof PieceSquadro) {
            $couleur = $piece->getCouleur();
            $direction = $piece->getDirection();
            $destX = $x;
            $destY = $y;


            if ($couleur !== PieceSquadro::BLANC && $couleur !== PieceSquadro::NOIR)
                throw new InvalidArgumentException("La piece selectionnée n'es pas Blanche ou Noir.");

            if ($couleur === PieceSquadro::NOIR) {
                switch ($direction) {
                    case PieceSquadro::NORD:
                        $vitesse = self::NOIR_V_ALLER[$y];
                        $destX -= $vitesse;
                        break;
                    case PieceSquadro::SUD:
                        $vitesse = self::NOIR_V_RETOUR[$y];
                        $destX += $vitesse;
                        break;
                }
            } else {
                switch ($direction) {
                    case PieceSquadro::EST:
                        $vitesse = self::BLANC_V_ALLER[$x];
                        $destY += $vitesse;
                        break;
                    case PieceSquadro::OUEST:
                        $vitesse = self::BLANC_V_RETOUR[$x];
                        $destY -= $vitesse;
                        break;
                }
            }
        }
        return [$destX, $destY];
    }
    /**
     * Récupère la pièce à la destination d'un mouvement donné.
     *
     * @param int $x L'index de la ligne de départ.
     * @param int $y L'index de la colonne de départ.
     * @return PieceSquadro La pièce à la destination calculée.
     */
    public function getDestination(int $x, int $y): ?PieceSquadro
    {
        list($destX, $destY) = $this->getCoordDestination($x, $y);
        return $this->getPiece($destX, $destY) ?? null;
    }

      /**
     * Convertit l'objet PlateauSquadro en une représentation JSON.
     *
     * @return string Chaîne JSON représentant l'objet PlateauSquadro.
     */
    public function toJson(): string {
        $plateauData = [];
        foreach ($this->plateau as $rowIndex => $row) {
            $rowData = [];
            
            foreach ($row as $colIndex => $piece) {
                $rowData[$colIndex] = json_decode($piece->toJson(), true);
            }
            $plateauData[$rowIndex] = $rowData;
        }
        // Sauvegarde des propriétés supplémentaires si nécessaire
        $data = [
            'plateau' => $plateauData,
            'lignesJouables' => $this->lignesJouables,
            'colonnesJouables' => $this->colonnesJouables,
        ];
        return json_encode($data);
    }

    /**
     * Recrée un objet PlateauSquadro à partir de sa représentation JSON.
     *
     * @param string $json Chaîne JSON représentant un objet PlateauSquadro.
     * @return PlateauSquadro L'objet PlateauSquadro reconstruit.
     */
    public static function fromJson(string $json): PlateauSquadro {
        $data = json_decode($json, true);
        $instance = new self();
        
        // Définit les lignes et colonnes jouables avec des valeurs par défaut si absentes dans le JSON
        $instance->lignesJouables = $data['lignesJouables'] ?? [1, 2, 3, 4, 5];
        $instance->colonnesJouables = $data['colonnesJouables'] ?? [1, 2, 3, 4, 5];
        
        // Reconstruit le plateau de jeu à partir des données JSON
        $instance->plateau = [];
        foreach ($data['plateau'] as $rowIndex => $rowData) {
            $arrayPiece = new ArrayPieceSquadro();
            foreach ($rowData as $colIndex => $pieceData) {
                $pieceJson = json_encode($pieceData);
                $piece = PieceSquadro::fromJson($pieceJson);
                $arrayPiece->offsetSet($colIndex, $piece);
            }
            $instance->plateau[$rowIndex] = $arrayPiece;
        }
        
        return $instance;
    }




    public function __toString(): string
    {
        return $this->toJson();
    }
}
