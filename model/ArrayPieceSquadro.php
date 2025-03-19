<?php

/**
 * Class ArrayPieceSquadro
 * Représente un tableau de pièces Squadro avec des fonctionnalités d'accès par tableau et de comptage.
 */
class ArrayPieceSquadro implements IteratorAggregate, ArrayAccess {
    // Tableau pour stocker les pièces
    private array $pieces = [];
   
    public function getIterator(): Traversable {
        return new ArrayIterator($this->pieces);
    }

    /**
     * Ajouter une pièce au tableau.
     *
     * @param PieceSquadro $piece La pièce à ajouter.
     * @return void
     */
    public function add(PieceSquadro $piece): void {
        $this->pieces[] = $piece;
    }

    /**
     * Supprimer une pièce par son index.
     *
     * @param int $index L'index de la pièce à supprimer.
     * @return void
     */
    public function remove(int $index): void {
        if (isset($this->pieces[$index])) {
            unset($this->pieces[$index]);
            // Réindexation des indices
            $this->pieces = array_values($this->pieces);
        }
    }

    /**
     * Convertir l'objet en chaîne de caractères.
     *
     * @return string La représentation en chaîne de l'objet.
     */
    public function __toString(): string {
        $output = "";
        foreach ($this->pieces as $piece) {
            $output .= $piece->__toString() . "\n";
        }
        return $output;
    }

    /**
     * Convertir l'objet en JSON.
     *
     * @return string La représentation JSON de l'objet.
     */
    public function toJson(): string {
        return json_encode(array_map(fn($piece) => json_decode($piece->toJson(), true), $this->pieces));
    }

    /**
     * Créer une instance à partir d'une chaîne JSON.
     *
     * @param string $json La chaîne JSON.
     * @return ArrayPieceSquadro L'instance créée.
     */
    public static function fromJson(string $json): ArrayPieceSquadro {
        $array = json_decode($json, true);
        $instance = new self();
        foreach ($array as $pieceData) {
            $instance->add(PieceSquadro::fromJson(json_encode($pieceData)));
        }
        return $instance;
    }

    /**
     * Vérifie si un offset existe.
     *
     * @param mixed $offset L'offset à vérifier.
     * @return bool True si l'offset existe, false sinon.
     */
    public function offsetExists($offset): bool {
        return isset($this->pieces[$offset]);
    }

    /**
     * Récupère la pièce à un offset donné.
     *
     * @param mixed $offset L'offset de la pièce à récupérer.
     * @return PieceSquadro|null La pièce à l'offset donné ou null si elle n'existe pas.
     */
    public function offsetGet($offset): ?PieceSquadro {
        return $this->pieces[$offset] ?? null;
    }

    /**
     * Définit une pièce à un offset donné.
     *
     * @param mixed $offset L'offset à définir.
     * @param mixed $value La pièce à définir.
     * @return void
     * @throws InvalidArgumentException Si la valeur n'est pas une instance de PieceSquadro.
     */
    public function offsetSet($offset, $value): void {
        if (!$value instanceof PieceSquadro) {
            throw new InvalidArgumentException("la valeur doit être une instance de PieceSquadro.");
        }
         // Si l'offset est null, ajoute la pièce à la fin
        if ($offset === null) {
            $this->add($value);
        } else {
            //La valeur doit etre écrasé apres comprehension du jeu
           $this->pieces[$offset] = $value;
        }
    }

    /**
     * Supprime une pièce à un offset donné.
     *
     * @param mixed $offset L'offset de la pièce à supprimer.
     * @return void
     */
    public function offsetUnset($offset): void {
        if (isset($this->pieces[$offset])) {
            unset($this->pieces[$offset]);
            array_values($this->pieces);
        }
    }

    /**
     * Compte le nombre de pièces dans le tableau.
     *
     * @return int Le nombre de pièces.
     */
    public function count(): int {
        return count($this->pieces);
    }
}
