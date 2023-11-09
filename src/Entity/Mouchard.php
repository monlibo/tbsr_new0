<?php

//declare(strict_types=1);

namespace App\Entity;

use App\Repository\MouchardRepository;
use App\traits\AttributsCommunsTraits;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MouchardRepository::class)]
class Mouchard
{
    use AttributsCommunsTraits;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $entite;

    #[ORM\Column(type: 'string')]
    private $idEntite;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $libelleEntite;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $action;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $profil;

    #[ORM\Column(type: 'text', nullable: true)]
    private $observations;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEntite()
    {
        return $this->entite;
    }

    /**
     * @param mixed $entite
     */
    public function setEntite($entite): void
    {
        $this->entite = $entite;
    }

    /**
     * @return mixed
     */
    public function getIdEntite()
    {
        return $this->idEntite;
    }

    /**
     * @param mixed $idEntite
     */
    public function setIdEntite($idEntite): void
    {
        $this->idEntite = $idEntite;
    }

    /**
     * @return mixed
     */
    public function getLibelleEntite()
    {
        return $this->libelleEntite;
    }

    /**
     * @param mixed $libelleEntite
     */
    public function setLibelleEntite($libelleEntite): void
    {
        $this->libelleEntite = $libelleEntite;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * @param mixed $profil
     */
    public function setProfil($profil): void
    {
        $this->profil = $profil;
    }

    /**
     * @return mixed
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * @param mixed $observations
     */
    public function setObservations($observations): void
    {
        $this->observations = $observations;
    }




}
