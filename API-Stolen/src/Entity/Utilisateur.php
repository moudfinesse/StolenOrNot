<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 *@ApiResource
 */
class Utilisateur implements \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=255)
     *@Groups({"cheese_listing:read","cheese_listing:write","foobar"})
     */
     private $username;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cheese_listing:read","cheese_listing:write","foobar"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
      *@Groups({"cheese_listing:read","cheese_listing:write","foobar"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
      *@Groups({"cheese_listing:read","cheese_listing:write","foobar"})
     */
    private $prenom;

    /**
     *@Groups({"cheese_listing:read","cheese_listing:write","foobar"})
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Appareil", mappedBy="utilisateur", *orphanRemoval=true)
     *@ApiSubresource
     *
     */
    private $appareils;

    public function __construct()
    {
        $this->appareils = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

   public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function __toString(): string
    {
        return $this->login;
    }
    /**
     * @return Collection|Appareil[]
     */
    public function getAppareils(): Collection
    {
        return $this->appareils;
    }

    public function addAppareil(Appareil $appareil): self
    {
        if (!$this->appareils->contains($appareil)) {
            $this->appareils[] = $appareil;
            $appareil->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAppareil(Appareil $appareil): self
    {
        if ($this->appareils->contains($appareil)) {
            $this->appareils->removeElement($appareil);
            // set the owning side to null (unless already changed)
            if ($appareil->getUtilisateur() === $this) {
                $appareil->setUtilisateur(null);
            }
        }

        return $this;
    }
     public function serialize()
    {
        return (serialize([
            $this->id,
            $this->prenom,
            $this->username,
            $this->password,
            $this->nom,
            $this->email,
           
        ]));
    }

   
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->prenom,
            $this->username,
            $this->password,
            $this->nom,
            $this->email,
         
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

   
    
}
