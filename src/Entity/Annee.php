<?php

namespace App\Entity;

use App\Repository\AnneeRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: AnneeRepository::class)]
class Annee
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
    #[ORM\Column(length: 255)]
    private ?string $valeur = null;

    #[ORM\Column]
    private ?bool $actif = null;

    #[Assert\NotBlank(message:"Ce champ ne doit pas etre vide!!")]
    #[ORM\Column(length: 255)]
    private ?string $archiver = null;

    public function __construct()
    {

    }

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

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;

        return $this;
    }

    public function getArchiver(): ?string
    {
        return $this->archiver;
    }

    public function setArchiver(string $archiver): static
    {
        $this->archiver = $archiver;

        return $this;
    }


    public function __toString(): string
    {
        return $this->getLibelle();//pour afficher le libellé dans le select et convertir en string

    }


}
