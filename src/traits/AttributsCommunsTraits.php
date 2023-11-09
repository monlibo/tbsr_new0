<?php


namespace App\traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait AttributsCommunsTraits
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $auteur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $last_updated = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $last_updated_auteur = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $supprimer = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimer_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $supprimer_auteur = null;

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getLastUpdated(): ?\DateTimeInterface
    {
        return $this->last_updated;
    }

    public function setLastUpdated(?\DateTimeInterface $last_updated): self
    {
        $this->last_updated = $last_updated;

        return $this;
    }

    public function getLastUpdatedAuteur(): ?string
    {
        return $this->last_updated_auteur;
    }

    public function setLastUpdatedAuteur(?string $last_updated_auteur): self
    {
        $this->last_updated_auteur = $last_updated_auteur;

        return $this;
    }

    public function isSupprimer(): ?bool
    {
        return $this->supprimer;
    }

    public function setSupprimer(bool $supprimer): self
    {
        $this->supprimer = $supprimer;

        return $this;
    }

    public function getSupprimerDate(): ?\DateTimeInterface
    {
        return $this->supprimer_date;
    }

    public function setSupprimerDate(?\DateTimeInterface $supprimer_date): self
    {
        $this->supprimer_date = $supprimer_date;

        return $this;
    }

    public function getSupprimerAuteur(): ?string
    {
        return $this->supprimer_auteur;
    }

    public function setSupprimerAuteur(?string $supprimer_auteur): self
    {
        $this->supprimer_auteur = $supprimer_auteur;

        return $this;
    }


}