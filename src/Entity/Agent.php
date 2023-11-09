<?php

namespace App\Entity;

use App\Repository\AgentRepository;
//use App\Service\StructureMethodes;
use App\traits\AttributsCommunsTraits;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
#[UniqueEntity(fields:["identifiant_agent"],message: 'Ce Agent a déjà été enregistré')]
class Agent
{
    use AttributsCommunsTraits;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $identifiant_agent = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $NPI;

    #[ORM\Column(type: 'string', length: 13, nullable: true)]
    private $IFU;

    #[ORM\Column(type: 'string', length: 6, nullable: true, unique: true)]
    private $matricule;

    #[ORM\Column(type: 'string', length: 64)]
    private $nom;

    #[ORM\Column(type: 'string', length: 128)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 128)]
    private $email;

    #[ORM\Column(type: 'string', length: 128, unique: true)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private $nomdejeunefille;

    #[ORM\Column(type: 'string', length: 8)]
    private $sexe;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_naissance;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private $lieu_naissance;

    #[ORM\OneToOne(mappedBy: 'agent', cascade: ['persist', 'remove'])]
    private ?User $utilisateur = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $fullname = null;

    #[ORM\OneToOne(targetEntity: Structure::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Structure $structure = null;

    #[ORM\ManyToOne(targetEntity: Fonction::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fonction $fonction = null;


    private $structureMethodes;



    public function __construct()
    {
        $this->setSupprimer(false);
    }

   /* public function getStructureActuelle(){

        $structureActuelle = $this->structureMethodes->rechercheStructureActuelleParAgent($this);
        return $structureActuelle->getStructureAbreviation();
    }*/

    public function __toString(): string
    {
        return $this->prenom.' '.$this->nom;
    }

    public function getIdentifiantAgent(): String
    {
        return $this->identifiant_agent;
    }

    public function getNPI(): ?string
    {
        return $this->NPI;
    }

    public function setNPI(?string $NPI): self
    {
        $this->NPI = $NPI;

        return $this;
    }

    public function getIFU(): ?string
    {
        return $this->IFU;
    }

    public function setIFU(?string $IFU): self
    {
        $this->IFU = $IFU;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): self
    {
        $this->matricule = $matricule;

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

    public function getNomdejeunefille(): ?string
    {
        return $this->nomdejeunefille;
    }

    public function setNomdejeunefille(?string $nomdejeunefille): self
    {
        $this->nomdejeunefille = $nomdejeunefille;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieu_naissance;
    }

    public function setLieuNaissance(?string $lieu_naissance): self
    {
        $this->lieu_naissance = $lieu_naissance;

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

//    public function setUtilisateur(User $utilisateur): self
//    {
//        // set the owning side of the relation if necessary
//        if ($utilisateur->getAgent() !== $this) {
//            $utilisateur->setAgent($this);
//        }
//
//        $this->utilisateur = $utilisateur;
//
//        return $this;
//    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email): void
    {
        $this->email = $email;
    }


    public function getTelephone()
    {
        return $this->telephone;
    }


    public function setTelephone($telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(?Structure $structure): void
    {
        $this->structure = $structure;
    }

    public function getFonction(): ?Fonction
    {
        return $this->fonction;
    }

    public function setFonction(?Fonction $fonction): void
    {
        $this->fonction = $fonction;
    }


    public function getStructureMethodes()
    {
        return $this->structureMethodes;
    }


    public function setStructureMethodes($structureMethodes): void
    {
        $this->structureMethodes = $structureMethodes;
    }



}
