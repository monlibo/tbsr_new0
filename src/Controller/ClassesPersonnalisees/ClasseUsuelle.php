<?php

namespace App\Controller\ClassesPersonnalisees;

use App\Entity\Annee;
use App\Entity\Mouchard;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ClasseUsuelle
{

    public static function saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, EntityManagerInterface $entityManager)
    {
        $mouchard = new Mouchard();
        $mouchard->setAuteur($auteur);
        $mouchard->setAction($action);
        $mouchard->setEntite($entite);
        $mouchard->setIdEntite($idEntite);
        $mouchard->setLibelleEntite($libelleEntite);
        $mouchard->setProfil($profil);
        $mouchard->setCreated(new \DateTime());
        $mouchard->setObservations($observations);
        $entityManager->persist($mouchard);


        $entityManager->flush();
    }

    public static function rechercheAnneeEnCours(EntityManagerInterface $entityManager)
    {
        $date=new \DateTime();
        $date1 = $date->format('Y-m-d');
        $annee = explode("-", $date1);
        $annee=$annee[0] +1;
        $objetAnnee = $entityManager->getRepository(Annee::class)->findOneBy(array('valeur' => $annee));

        return $objetAnnee;
    }

}