<?php

namespace App\Controller\Annee;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Annee;
use App\Form\AnneeType;
use App\Repository\AnneeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/annee')]
class EditAnneeController extends AbstractController
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}/edit', name: 'app_annee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annee $annee, AnneeRepository $anneeRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(AnneeType::class, $annee);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $anneeExistant = $anneeRepository->findOneBy(array('libelle' => $annee->getLibelle(), 'supprimer' => false));
                    if ($anneeExistant != null) {
                        if ($annee->getId() != $anneeExistant->getId()) {
                            $this->addFlash('error', 'Une annee ayant le même nom ' . $anneeExistant->getLibelle() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_annee_edit', array('id' => $annee->getId()));
                        }

                    }

                    $this->entityManager->flush();

                    $this->saveMouchard("annee", $annee->getId(), $annee->getLibelle(),
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement modifié avec succès ");
                    return $this->redirectToRoute('app_annee_show', ['id' => $annee->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('annee/edit.html.twig', [
                    'annee' => $annee,
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
