<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProfilRepository::class)]
class Profil
{
    use AttributsCommunsTraits;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $code;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $libelle;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'profils')]
    private Collection $user;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $niveauProfil = null;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }
    
    public function __toString(): string
    {
        return $this->getLibelle();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    public function getNiveauProfil(): ?int
    {
        return $this->niveauProfil;
    }

    public function setNiveauProfil(?int $niveauProfil): self
    {
        $this->niveauProfil = $niveauProfil;

        return $this;
    }
}
