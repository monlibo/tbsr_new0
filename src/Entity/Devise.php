<?php

namespace App\Entity;

use App\Repository\DeviseRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DeviseRepository::class)]
#[UniqueEntity(fields:'code',message:"Ce code existe déja !!")]

class Devise
{
    use AttributsCommunsTraits;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message:"Ce champ ne doit pas etre vide !!")]
    #[ORM\Column(length: 255 , unique:true)]
    private ?string $code = null;

    #[Assert\NotBlank(message:"Ce champ ne doit pas etre vide !!")]
    #[Assert\Range(min:1, max:100,notInRangeMessage:"Cette valeur doit étre comprise entre 1 et 100")]
    #[Assert\Type(type:"numeric", message:"Ce champ ne doit pas etre vide !!")]
    #[ORM\Column]
    private ?float $taux = null ;

    #[Assert\NotBlank(message:"Ce champ ne doit pas etre vide !!")]
    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getTaux(): ?float
    {
        return $this->taux;
    }

    public function setTaux(float $taux): static
    {
        $this->taux = $taux;

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

}
