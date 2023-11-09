<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username','agent'], message: 'Ce nom d\'ulisateur ou cet agent existe déja..')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    private ?string $plainPassword;

    #[ORM\Column(type: 'boolean')]
    private bool $enabled = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail = null;


    #[ORM\Column(type: 'boolean')]
    private bool $premiereConnexion = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datePremiereConnexion = null;


    #[ORM\OneToOne(inversedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'identifiant_agent', referencedColumnName: 'identifiant_agent', nullable: true , unique:true)]
    private ?Agent $agent = null;

    #[ORM\ManyToMany(targetEntity: Profil::class, mappedBy: 'user')]
    private Collection $profils;

    #[ORM\Column(name: 'last_login', type: 'datetime', nullable: true)]
    private ?\DateTime $lastLogin;

    #[ORM\Column(length: 245)]
    private ?string $codeActivation = null;

    public function __construct()
    {
        $this->profils = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(Agent $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return Collection<int, Profil>
     */
    public function getProfils(): Collection
    {
        return $this->profils;
    }

    public function addProfil(Profil $profil): self
    {
        if (!$this->profils->contains($profil)) {
            $this->profils->add($profil);
            $profil->addUser($this);
        }

        return $this;
    }

    public function removeProfil(Profil $profil): self
    {
        if ($this->profils->removeElement($profil)) {
            $profil->removeUser($this);
        }

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function isPremiereConnexion(): ?bool
    {
        return $this->premiereConnexion;
    }

    public function setPremiereConnexion(bool $premiereConnexion): self
    {
        $this->premiereConnexion = $premiereConnexion;

        return $this;
    }

    public function getDatePremiereConnexion(): ?\DateTimeInterface
    {
        return $this->datePremiereConnexion;
    }

    public function setDatePremiereConnexion(?\DateTimeInterface $datePremiereConnexion): self
    {
        $this->datePremiereConnexion = $datePremiereConnexion;

        return $this;
    }

    public function getCodeActivation(): ?string
    {
        return $this->codeActivation;
    }

    public function setCodeActivation(string $codeActivation): static
    {
        $this->codeActivation = $codeActivation;

        return $this;
    }
    

    
}
