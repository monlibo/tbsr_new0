<?php

namespace App\Entity;

use App\Repository\ActionReformeRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionReformeRepository::class)]
class ActionReforme
{
    use AttributsCommunsTraits;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reforme $reforme = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activite $activite = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getReforme(): ?Reforme
    {
        return $this->reforme;
    }

    public function setReforme(?Reforme $reforme): static
    {
        $this->reforme = $reforme;

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
