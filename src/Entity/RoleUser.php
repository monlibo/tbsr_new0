<?php

namespace App\Entity;

use App\Repository\RoleUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: RoleUserRepository::class)]
class RoleUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(type: 'uuid', nullable:true)]
    private ?Uuid $iduser = null;

    #[ORM\Column(type: 'uuid', nullable:true)]
    private ?Uuid $idrole = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getIduser(): ?Uuid
    {
        return $this->iduser;
    }

    public function setIduser(Uuid $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getIdrole(): ?Uuid
    {
        return $this->idrole;
    }

    public function setIdrole(Uuid $idrole): static
    {
        $this->idrole = $idrole;

        return $this;
    }
}
