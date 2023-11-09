<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV7 as Uuid;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    use AttributsCommunsTraits;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $code;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $libelle = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $niveauRole = null;

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
    }
    public function setId(Uuid $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code): void
    {
        $this->code = $code;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNiveauRole(): ?int
    {
        return $this->niveauRole;
    }

    public function setNiveauRole(?int $niveauRole): self
    {
        $this->niveauProfil = $niveauRole;

        return $this;
    }
}
