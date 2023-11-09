<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
class Activite
{

    use AttributsCommunsTraits;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id = null;

    #[ORM\Column(length: 50)]
    private ?string $numActivite = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $libelleActivite = null;

    #[ORM\OneToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    private ?self $activite = null;

    #[ORM\ManyToOne]
    private ?TypeActivite $typeActivite = null;

    #[ORM\ManyToOne]
    private ?Structure $structure = null;

    #[ORM\ManyToOne]
    private ?Annee $anneeDebut = null;

    #[ORM\ManyToOne]
    private ?Annee $anneeFin = null;

    #[ORM\ManyToOne]
    private ?Annee $annee = null;

    #[ORM\ManyToOne]
    private ?Devise $devise = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $objectifPrincipal = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $objectifSpecifique = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $libelleIntComp = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $libelleIndicateurIndividuel = null;

    #[ORM\Column(nullable: true)]
    private ?float $coutActivite = null;

    #[ORM\Column(nullable: true)]
    private ?float $coutActiviteFcfa = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $resultatAttendu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDelaiExecution = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateExecution = null;

    #[ORM\Column(nullable: true)]
    private ?float $poids = null;

    #[ORM\Column(nullable: true)]
    private ?bool $archiver = null;

    #[ORM\OneToMany(mappedBy: 'activite', targetEntity: ActionBailleur::class)]
    private Collection $actionBailleurs;

    public function __construct()
    {
        $this->actionBailleurs = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getLibelleActivite();//pour afficher le libellé dans le select et convertir en string
    }



    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNumActivite(): ?string
    {
        return $this->numActivite;
    }

    public function setNumActivite(string $numActivite): static
    {
        $this->numActivite = $numActivite;

        return $this;
    }

    public function getLibelleActivite(): ?string
    {
        return $this->libelleActivite;
    }

    public function setLibelleActivite(string $libelleActivite): static
    {
        $this->libelleActivite = $libelleActivite;

        return $this;
    }

    public function getActivite(): ?self
    {
        return $this->activite;
    }

    public function setActivite(?self $activite): static
    {
        $this->activite = $activite;

        return $this;
    }

    public function getTypeActivite(): ?TypeActivite
    {
        return $this->typeActivite;
    }

    public function setTypeActivite(?TypeActivite $typeActivite): static
    {
        $this->typeActivite = $typeActivite;

        return $this;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(?Structure $structure): static
    {
        $this->structure = $structure;

        return $this;
    }

    public function getAnneeDebut(): ?Annee
    {
        return $this->anneeDebut;
    }

    public function setAnneeDebut(?Annee $anneeDebut): static
    {
        $this->anneeDebut = $anneeDebut;

        return $this;
    }

    public function getAnneeFin(): ?Annee
    {
        return $this->anneeFin;
    }

    public function setAnneeFin(?Annee $anneeFin): static
    {
        $this->anneeFin = $anneeFin;

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

    public function getDevise(): ?Devise
    {
        return $this->devise;
    }

    public function setDevise(?Devise $devise): static
    {
        $this->devise = $devise;

        return $this;
    }

    public function getObjectifPrincipal(): ?string
    {
        return $this->objectifPrincipal;
    }

    public function setObjectifPrincipal(string $objectifPrincipal): static
    {
        $this->objectifPrincipal = $objectifPrincipal;

        return $this;
    }

    public function getObjectifSpecifique(): ?string
    {
        return $this->objectifSpecifique;
    }

    public function setObjectifSpecifique(?string $objectifSpecifique): static
    {
        $this->objectifSpecifique = $objectifSpecifique;

        return $this;
    }

    public function getLibelleIntComp(): ?string
    {
        return $this->libelleIntComp;
    }

    public function setLibelleIntComp(?string $libelleIntComp): static
    {
        $this->libelleIntComp = $libelleIntComp;

        return $this;
    }

    public function getLibelleIndicateurIndividuel(): ?string
    {
        return $this->libelleIndicateurIndividuel;
    }

    public function setLibelleIndicateurIndividuel(?string $libelleIndicateurIndividuel): static
    {
        $this->libelleIndicateurIndividuel = $libelleIndicateurIndividuel;

        return $this;
    }

    public function getCoutActivite(): ?float
    {
        return $this->coutActivite;
    }

    public function setCoutActivite(?float $coutActivite): static
    {
        $this->coutActivite = $coutActivite;

        return $this;
    }

    public function getCoutActiviteFcfa(): ?float
    {
        return $this->coutActiviteFcfa;
    }

    public function setCoutActiviteFcfa(?float $coutActiviteFcfa): static
    {
        $this->coutActiviteFcfa = $coutActiviteFcfa;

        return $this;
    }

    public function getResultatAttendu(): ?string
    {
        return $this->resultatAttendu;
    }

    public function setResultatAttendu(?string $resultatAttendu): static
    {
        $this->resultatAttendu = $resultatAttendu;

        return $this;
    }

    public function getDateDelaiExecution(): ?\DateTimeInterface
    {
        return $this->dateDelaiExecution;
    }

    public function setDateDelaiExecution(?\DateTimeInterface $dateDelaiExecution): static
    {
        $this->dateDelaiExecution = $dateDelaiExecution;

        return $this;
    }

    public function getDateExecution(): ?\DateTimeInterface
    {
        return $this->dateExecution;
    }

    public function setDateExecution(?\DateTimeInterface $dateExecution): static
    {
        $this->dateExecution = $dateExecution;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(?float $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function isArchiver(): ?bool
    {
        return $this->archiver;
    }

    public function setArchiver(?bool $archiver): static
    {
        $this->archiver = $archiver;

        return $this;
    }

    /**
     * @return Collection<int, ActionBailleur>
     */
    public function getActionBailleurs(): Collection
    {
        return $this->actionBailleurs;
    }

    public function addActionBailleur(ActionBailleur $actionBailleur): static
    {
        if (!$this->actionBailleurs->contains($actionBailleur)) {
            $this->actionBailleurs->add($actionBailleur);
            $actionBailleur->setActivite($this);
        }

        return $this;
    }

    public function removeActionBailleur(ActionBailleur $actionBailleur): static
    {
        if ($this->actionBailleurs->removeElement($actionBailleur)) {
            // set the owning side to null (unless already changed)
            if ($actionBailleur->getActivite() === $this) {
                $actionBailleur->setActivite(null);
            }
        }

        return $this;
    }
}
