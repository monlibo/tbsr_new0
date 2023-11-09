<?php

namespace App\Entity;

use App\Repository\ExecuterRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExecuterRepository::class)]
class Executer
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

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Periodicite $periodicite = null;

    #[ORM\Column]
    private ?float $tauxPrevu = null;

    #[ORM\Column]
    private ?float $tauxRealiser = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $observation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateExecution = null;

    #[ORM\Column(length: 255)]
    private ?string $archives = null;

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
        $this->activite = $activite;

        return $this;
    }

    public function getPeriodicite(): ?Periodicite
    {
        return $this->periodicite;
    }

    public function setPeriodicite(?Periodicite $periodicite): static
    {
        $this->periodicite = $periodicite;

        return $this;
    }

    public function getTauxPrevu(): ?float
    {
        return $this->tauxPrevu;
    }

    public function setTauxPrevu(float $tauxPrevu): static
    {
        $this->tauxPrevu = $tauxPrevu;

        return $this;
    }

    public function getTauxRealiser(): ?float
    {
        return $this->tauxRealiser;
    }

    public function setTauxRealiser(float $tauxRealiser): static
    {
        $this->tauxRealiser = $tauxRealiser;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(string $observation): static
    {
        $this->observation = $observation;

        return $this;
    }

    public function getDateExecution(): ?\DateTimeInterface
    {
        return $this->dateExecution;
    }

    public function setDateExecution(\DateTimeInterface $dateExecution): static
    {
        $this->dateExecution = $dateExecution;

        return $this;
    }

    public function getArchives(): ?string
    {
        return $this->archives;
    }

    public function setArchives(string $archives): static
    {
        $this->archives = $archives;

        return $this;
    }
}
