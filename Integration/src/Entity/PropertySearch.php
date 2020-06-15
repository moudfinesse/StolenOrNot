<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * cette classe gère la recherche avec le formulaire du dashboard
 */
class PropertySearch{
/**
 * @var string|null
 */
public $modele;

public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): PropertySearch
    {
        $this->modele = $modele;

        return $this;
    }


}