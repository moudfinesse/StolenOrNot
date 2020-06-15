<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(
 *  fields = {"email"},
 *  message = "L'email que vous avez indiqué est déja utilisé!")
 */
class Utilisateur implements UserInterface ,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
     /**
     * @ORM\Column(type="string", length=255)
     */
     private $username;

   /**
     * @ORM\Column(type="string", length=255,nullable=false)
     */
     private $nom;

     /**
      * @ORM\Column(type="string", length=255, nullable=false)
      */
     private $prenom;
 
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractéres")
     
     */
    private $password;


    /**
     * @Assert\EqualTo(propertyPath="password",message="Vous n'avez pas tapé le même mot de passe")
     */

    public $confirm_password;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $activation_token;
     /**
     * @Assert\Length(max=250)
     */
     private $plainPassword;
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
     private $reset_token;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Appareil", mappedBy="utilisateur", orphanRemoval=true)
     */
     private $appareils;


     public function __construct(

     )
     {
         $this->appareils = new ArrayCollection();
     }


    public function getId(): ?int
    {
        return $this->id;
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
public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
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


    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function eraseCredentials()
    {
        
    }

    public function getSalt()
    {
        
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;

        return $this;
    }
    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;

        return $this;
    }
    
    public function __toString()
    {
        return $this->getUsername();
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
    /**
     * @return Collection|Appareil[]
     */
    public function getAppareils(): Collection
    {
        return $this->appareils;
    }
    function getPlainPassword() {
        return $this->plainPassword;
    }
    function setPlainPassword($plainPassword) {
        $this->plainPassword = $plainPassword;
    }
    

}
