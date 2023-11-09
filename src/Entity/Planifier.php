<?php

namespace App\Entity;

use App\Repository\PlanifierRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanifierRepository::class)]
class Planifier
{
    Use AttributsCommunsTraits;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Annee $annee = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activite $activite = null;

    #[ORM\Column]
    private ?float $poidsAction = null;

    #[ORM\Column]
    private ?bool $archiver = null;

    public function getId(): ?int
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

    public function getAnnee(): ?Annee
    {
        return $this->annee;
    }

    public function setAnnee(?Annee $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): static
    {
        $this->$activite = $activite;

        return $this;
    }

    public function getPoidsAction(): ?float
    {
        return $this->poidsAction;
    }

    public function setPoidsAction(float $poidsAction): static
    {
        $this->poidsAction = $poidsAction;

        return $this;
    }

    public function isArchiver(): ?bool
    {
        return $this->archiver;
    }

    public function setArchiver(bool $archiver): static
    {
        $this->archiver = $archiver;

        return $this;
    }
}
