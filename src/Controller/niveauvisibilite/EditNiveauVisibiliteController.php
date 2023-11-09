<?php

namespace App\Controller\niveauvisibilite;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\NiveauVisibilite;
use App\Form\NiveauVisibiliteType;
use App\Repository\NiveauVisibiliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/niveauvisibilite')]
class EditNiveauVisibiliteController extends AbstractController
{


    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}/edit', name: 'app_niveauvisibilite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NiveauVisibilite $niveauVisibilite, EntityManagerInterface $entityManager, NiveauVisibiliteRepository $niveauVisibiliteRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(NiveauVisibiliteType::class, $niveauVisibilite);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $niveauvisibiliteExistant = $niveauVisibiliteRepository->findOneBy(array('libelle' => $niveauVisibilite->getLibelle(), 'supprimer' => false));
                    if ($niveauvisibiliteExistant != null) {
                        if ($niveauVisibilite->getId() != $niveauvisibiliteExistant->getId()) {
                            $this->addFlash('error', 'Un niveau de visibilité ayant le même libelle ' . $niveauvisibiliteExistant->getLibelle() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_bailleur_edit', array('id' => $niveauVisibilite->getId()));
                        }
                    }

                    $entityManager->flush();
                    $this->saveMouchard("Le niveau de visibilité", $niveauVisibilite->getId(), $niveauVisibilite->getLibelle(),
                        "modification", "profiluser", "user", "");

                    $this->addFlash('success', "Enregistrement modifié avec succès ");

                    return $this->redirectToRoute('app_niveauvisibilite_show', ['id' =>$niveauVisibilite->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('niveauvisibilite/edit.html.twig', [
                    'niveau_visibilite' => $niveauVisibilite,
                    'form' => $form,
                ]);

            }else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        }else {
            return $this->redirectToRoute('tbsr_capr_default');
        }
    }
    public
    function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }
}
