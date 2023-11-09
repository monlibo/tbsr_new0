<?php

namespace App\Controller\suggestion;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Suggestion;
use App\Form\SuggestionType;
use App\Repository\SuggestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/suggestion')]
class EditSuggestionController extends AbstractController
{


    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}/edit', name: 'app_suggestion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Suggestion $suggestion, EntityManagerInterface $entityManager, SuggestionRepository $suggestionRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(SuggestionType::class, $suggestion);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $suggestionExistant = $suggestionRepository->findOneBy(array('libelle' => $suggestion->getLibelle(), 'supprimer' => false));
                    if ($suggestionExistant != null) {
                        if ($suggestion->getId() != $suggestionExistant->getId()) {
                            $this->addFlash('error', 'Une suggestion ayant le même libelle ' . $suggestionExistant->getLibelle() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_suggestion_edit', array('id' => $suggestion->getId()));
                        }
                    }

                    $entityManager->flush();

                    $this->saveMouchard("suggestion", $suggestion->getId(), $suggestion->getLibelle(),
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Suggestion modifié avec succès ");
                    return $this->redirectToRoute('app_suggestion_show', ['id' => $suggestion->getId()], Response::HTTP_SEE_OTHER);

                }

                return $this->render('suggestion/edit.html.twig', [
                    'suggestion' => $suggestion,
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
