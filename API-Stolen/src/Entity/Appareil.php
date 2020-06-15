<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;


/**
 *@ApiResource(
 *normalizationContext={"groups"={"cheese_listing:read"}},
 *denormalizationContext={"groups"={"cheese_listing:write"}},

 * )
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
     *@Groups({"cheese_listing:read","cheese_listing:write"})
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=100)
     *@Groups({"cheese_listing:read","cheese_listing:write"})
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=100)
     *@Groups({"cheese_listing:read","cheese_listing:write"})
     */
    private $capacite;

    /**
     * @ORM\Column(type="string", length=100, nullable=true,unique=true)
     *@Groups({"cheese_listing:read","cheese_listing:write"})
     *
     */
    private $imei;

    /**
     * @ORM\Column(type="string", length=100,unique=true)
     *@Groups({"cheese_listing:read","cheese_listing:write"})
     */
    private $serial;

    /**
    
    * @ORM\Column(type="string", length=100, nullable=true,unique=true)
    *@Groups({"cheese_listing:read","cheese_listing:write"})
    *
    */
    private $mac;

    /**
     * @ORM\Column(type="text")
     *@Groups({"cheese_listing:read","cheese_listing:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     *@Groups({"cheese_listing:read","cheese_listing:write"})
     */
    private $technicals;

    /**
     * @ORM\Column(type="string", length=100)
     *@Groups({"cheese_listing:read","cheese_listing:write"})
     */
    private $statut;


     /**
      * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", *inversedBy="appareils",cascade={"persist"})
      * @ORM\JoinColumn(nullable=false)
      *@Groups({"cheese_listing:read","cheese_listing:write","foobar"})
      */
     private $utilisateur;
      /**
      * @ORM\Column(type="datetime")
      *@Groups({"cheese_listing:read","cheese_listing:write"})
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

