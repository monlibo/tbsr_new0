<?php

namespace App\Entity;

use App\Repository\ActionBailleurRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionBailleurRepository::class)]
class ActionBailleur
{
    use AttributsCommunsTraits;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bailleur $bailleur = null;

    #[ORM\ManyToOne(inversedBy: 'actionBailleurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activite $activite = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getBailleur(): ?Bailleur
    {
        return $this->bailleur;
    }

    public function setBailleur(?Bailleur $bailleur): static
    {
        $this->bailleur = $bailleur;

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
}
