<?php

namespace App\Controller\bailleur;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Bailleur;
use App\Form\BailleurType;
use App\Repository\BailleurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/bailleur')]
class AddBailleurController   extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_bailleur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BailleurRepository $bailleurRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $bailleur = new Bailleur();
                $form = $this->createForm(BailleurType::class, $bailleur);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    //Ainsi de suite pour les autres autres champs à contrôler
                    $bailleurExistant = $bailleurRepository->findOneBy(array('libelle' => $bailleur->getLibelle(), 'supprimer' => false));
                    if ($bailleurExistant != null) {
                        $this->addFlash('error', 'Un bailleur ayant le même libellé ' . $bailleurExistant->getLibelle() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_bailleur_new', array('id' => $bailleur->getId()));
                    }


                    //$bailleur->setLibelle()
                    $bailleur->setSupprimer(false);
                    //$bailleur->setAuteur($currentUser->getUserIdentifier());
                    $bailleur->setCreated(new \DateTimeImmutable());

                    $this->entityManager->persist($bailleur);
                    $this->entityManager->flush();


                    //Mouchard
                    $this->saveMouchard("bailleur", $bailleur->getId(), $bailleur->getLibelle(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', 'Enregistrement du bailleur '. $bailleur->getLibelle() .' effectué avec succès.');
                    return $this->redirectToRoute('app_bailleur_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('bailleur/new.html.twig', [
                    'bailleur' => $bailleur,
                    'form' => $form,
                ]);
            } else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        } else {
            return $this->redirectToRoute('tbsr_capr_default');
            // throw new AccessDeniedException();
        }
    }


    public function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }

}
