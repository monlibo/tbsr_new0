<?php

namespace App\Entity;

use App\Repository\TypeActiviteRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: TypeActiviteRepository::class)]
class TypeActivite
{

    use AttributsCommunsTraits;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $libelle = null;

    #[ORM\OneToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?self $typtActivite = null;

    #[ORM\ManyToOne(targetEntity: Periode::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Periode $periode = null;

    #[ORM\Column]
    private ?int $annee = null;

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

    public function getTyptActivite(): ?self
    {
        return $this->typtActivite;
    }

    public function setTyptActivite(self $typtActivite): static
    {
        $this->typtActivite = $typtActivite;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getPeriode(): ?Periode
    {
        return $this->periode;
    }

    public function setPeriode(?Periode $periode): void
    {
        $this->periode = $periode;
    }

    public function __toString(): string
    {
        return $this->getLibelle();//pour afficher le libellé dans le select et convertir en string
    }


}
