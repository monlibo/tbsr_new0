<?php

namespace App\Controller\bailleur;

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
class EditBailleurController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}/edit', name: 'app_bailleur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bailleur $bailleur, BailleurRepository $bailleurRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(BailleurType::class, $bailleur);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $bailleurExistant = $bailleurRepository->findOneBy(array('libelle' => $bailleur->getLibelle(), 'supprimer' => false));
                    if ($bailleurExistant != null) {
                        if ($bailleur->getId() != $bailleurExistant->getId()) {
                            $this->addFlash('error', 'Un bailleur ayant le même nom ' . $bailleurExistant->getLibelle() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_bailleur_edit', array('id' => $bailleur->getId()));
                        }
                    }

                    //$bailleur->setLastUpdatedAuteur($currentUser->getUserIdentifier());
                    $bailleur->setLastUpdated(new \DateTimeImmutable());
                    $this->entityManager->flush();

                    $this->saveMouchard("bailleur", $bailleur->getId(), $bailleur->getLibelle(),
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement modifié avec succès ");
                    return $this->redirectToRoute('app_bailleur_show', ['id' => $bailleur->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('bailleur/edit.html.twig', [
                    'bailleur' => $bailleur,
                    'form' => $form,
                ]);
            } else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        } else {
            return $this->redirectToRoute('tbsr_capr_default');
        }


    }


    public
    function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }

}
