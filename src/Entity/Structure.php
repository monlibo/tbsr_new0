<?php

namespace App\Entity;

use App\Repository\StructureRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
class Structure
{
    use AttributsCommunsTraits;
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
//    #[ORM\Id]
//    #[ORM\GeneratedValue]
//    #[ORM\Column]
    private ?string $id = null;

    #[Assert\NotBlank(message:"Ce champ ne doit pas etre vide!!")]
    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[Assert\NotBlank(message:"Ce champ ne doit pas etre vide!!")]
    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(type: 'string', length: 128, unique: true)]
    private ?int $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    public function __construct()
    {
    }

    public function getId(): ?string
    {
        return $this->id;
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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function __toString(): string
    {
        return $this->getLibelle();//pour afficher le libellé dans le select et convertir en string

    }


}
