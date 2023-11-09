<?php

namespace App\Entity;

use App\Repository\TypeGrapheRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TypeGrapheRepository::class)]
class TypeGraphe
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
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $urlAbsolute = null;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getUrlAbsolute(): ?string
    {
        return $this->urlAbsolute;
    }

    public function setUrlAbsolute(string $urlAbsolute): static
    {
        $this->urlAbsolute = $urlAbsolute;

        return $this;
    }


    public function __toString(): string
    {
        return $this->getLibelle();//pour afficher le libellé dans le select et convertir en string

    }

}
