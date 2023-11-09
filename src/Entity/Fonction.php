<?php

namespace App\Entity;
use App\Repository\FonctionRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FonctionRepository::class)]
#[UniqueEntity(fields:"code", message: "Ce code existe déja !!")]
class Fonction
{
    use AttributsCommunsTraits;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[Assert\NotBlank(message: "Ce champs ne doit pas etre vide !!")]
    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[Assert\NotBlank(message: "Ce champs ne doit pas etre vide !!")]
    #[ORM\Column(length: 255, unique:true )]
    private ?string $code = null;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    
}
