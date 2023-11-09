<?php

namespace App\Entity;

use App\Repository\RapportRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RapportRepository::class)]
class Rapport
{
    use AttributsCommunsTraits;
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id = null;

    #[Assert\NotBlank(message:"Ce champ ne doit pas etre vide!!")]
    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[Assert\NotBlank(message:"Ce champ ne doit pas etre vide!!")]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentaire = null;
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Structure $structure = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeDonnee $typeDonnee = null;

    #[Assert\NotBlank(message:"Ce champ ne doit pas etre vide!!")]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?NiveauVisibilite $niveauVisibilite = null;

    #[Assert\NotBlank(message:"Ce champ ne doit pas etre vide!!")]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeGraphe $typeGraphe = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(?Structure $structure): static
    {
        $this->structure = $structure;

        return $this;
    }

    public function getTypeDonnee(): ?TypeDonnee
    {
        return $this->typeDonnee;
    }

    public function setTypeDonnee(?TypeDonnee $typeDonnee): static
    {
        $this->typeDonnee = $typeDonnee;

        return $this;
    }

    public function getNiveauVisibilite(): ?NiveauVisibilite
    {
        return $this->niveauVisibilite;
    }

    public function setNiveauVisibilite(?NiveauVisibilite $niveauVisibilite): static
    {
        $this->niveauVisibilite = $niveauVisibilite;

        return $this;
    }

    public function getTypeGraphe(): ?TypeGraphe
    {
        return $this->typeGraphe;
    }

    public function setTypeGraphe(?TypeGraphe $typeGraphe): static
    {
        $this->typeGraphe = $typeGraphe;

        return $this;
    }

//(targetEntity: Structure::class, cascade: ['persist', 'remove'])

}
