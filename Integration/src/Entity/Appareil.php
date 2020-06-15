<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Appareil
 */
/**
 * @ORM\Entity(repositoryClass="App\Repository\AppareilRepository")
 */

class Appareil
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $capacite;

    /**
     * @ORM\Column(type="string", length=100, nullable=true,unique=true)
     *@Assert\Length(
     *      min = 15,
     *      max = 15,
     *      minMessage = "L'adresse IMEI ne peut pas etre inferieure a  {{ limit }} caractères",
     *      maxMessage = "L'adresse IMEI ne peut pas exceder {{ limit }} caractères",
     *   
     * )
     *
     */
    private $imei;

    /**
     * @ORM\Column(type="string", length=100,unique=true)
     */
    private $serial;

    /**
    
    * @ORM\Column(type="string", length=100, nullable=true,unique=true)
    *@Assert\Length(
     *      min = 17,
     *      max = 17,
     *      minMessage = "L'adresse mac ne peut pas etre inferieure à  {{ limit }} caractères",
     *      maxMessage = "L'adresse mac ne peut pas exceder {{ limit }} caractères",
     *   
     * )
    *
    */
    private $mac;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $technicals;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $statut;


     /**
      * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="appareils",cascade={"persist"})
      * @ORM\JoinColumn(nullable=false)
      */
     private $utilisateur;
      /**
      * @ORM\Column(type="datetime")
      * @var string A "Y-m-d H:i:s" formatted value
      */
      private $createdAt;


    public function getId(): ?int
    {
        return $this->id;
    }
    
    
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getCapacite(): ?string
    {
        return $this->capacite;
    }

    public function setCapacite(string $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getImei(): ?string
    {
        return $this->imei;
    }

    public function setImei(?string $imei): self
    {
        $this->imei = $imei;

        return $this;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(string $serial): self
    {
        $this->serial = $serial;

        return $this;
    }

    public function getMac(): ?string
    {
        return $this->mac;
    }

    public function setMac(?string $mac): self
    {
        $this->mac = $mac;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTechnicals(): ?string
    {
        return $this->technicals;
    }

    public function setTechnicals(string $technicals): self
    {
        $this->technicals = $technicals;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}

