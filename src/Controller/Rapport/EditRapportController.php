<?php

namespace App\Controller\Rapport;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Rapport;
use App\Form\AnneeType;
use App\Form\RapportType;
use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/rapport')]
class EditRapportController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }



    #[Route('/{id}/edit', name: 'app_rapport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(RapportType::class, $rapport);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $rapportExistant = $rapportRepository->findOneBy(array('libelle' => $rapport->getLibelle(), 'supprimer' => false));
                    if ($rapportExistant != null) {
                        if ($rapport->getId() != $rapportExistant->getId()) {
                            $this->addFlash('error', 'Un rapport ayant le même nom ' . $rapportExistant->getLibelle() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_rapport_edit', array('id' => $rapport->getId()));
                        }

                    }

                    $this->entityManager->flush();

                    $this->saveMouchard("rapport", $rapport->getId(), $rapport->getLibelle(),
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement modifié avec succès ");
                    return $this->redirectToRoute('app_rapport_show', ['id' => $rapport->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('rapport/edit.html.twig', [
                    'rapport' => $rapport,
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
