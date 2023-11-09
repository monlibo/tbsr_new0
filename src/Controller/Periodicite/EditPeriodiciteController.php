<?php

namespace App\Controller\Periodicite;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Periodicite;
use App\Form\AnneeType;
use App\Form\PeriodiciteType;
use App\Repository\PeriodiciteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/periodicite')]
class EditPeriodiciteController extends AbstractController
{


    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}/edit', name: 'app_periodicite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Periodicite $periodicite, EntityManagerInterface $entityManager, PeriodiciteRepository $periodiciteRepository): Response
    {



        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(PeriodiciteType::class, $periodicite);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $periodiciteExistant = $periodiciteRepository->findOneBy(array('libelle' => $periodicite->getLibelle(), 'supprimer' => false));
                    if ($periodiciteExistant != null) {
                        if ($periodicite->getId() != $periodiciteExistant->getId()) {
                            $this->addFlash('error', 'Une periodicite ayant le même nom ' . $periodiciteExistant->getLibelle() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_periodicite_edit', array('id' => $periodicite->getId()));
                        }

                    }

                    $this->entityManager->flush();

                    $this->saveMouchard("periodicite", $periodicite->getId(), $periodicite->getLibelle(),
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement modifié avec succès ");
                    return $this->redirectToRoute('app_periodicite_show', ['id' => $periodicite->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('periodicite/edit.html.twig', [
                    'periodicite' => $periodicite,
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
