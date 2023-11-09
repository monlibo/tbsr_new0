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
class AddSuggestionController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_suggestion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SuggestionRepository $suggestionRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $suggestion = new Suggestion();
                $form = $this->createForm(SuggestionType::class, $suggestion);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    //Ainsi de suite pour les autres autres champs à contrôler
                    $suggestionExistant = $suggestionRepository->findOneBy(array('libelle' => $suggestion->getLibelle(), 'supprimer' => false));
                    if ($suggestionExistant != null) {
                        $this->addFlash('error', 'Une suggestion ayant le même libellé ' . $suggestionExistant->getLibelle() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_bailleur_new', array('id' => $suggestion->getId()));
                    }


//            $suggestion->setCreatedAt(new \DateTimeImmutable());

                    //$bailleur->setLibelle()
                    $suggestion->setSupprimer(false);
                    $suggestion->setDate(new \DateTime());
                    //$bailleur->setAuteur($currentUser->getUserIdentifier());
                    $suggestion->setCreated(new \DateTimeImmutable());

                    $entityManager->persist($suggestion);
                    $entityManager->flush();

                    //Mouchard
                    $this->saveMouchard("bailleur", $suggestion->getId(), $suggestion->getLibelle(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', 'Enregistrement de la suggestion '. $suggestion->getLibelle() .' effectué avec succès.');

                    return $this->redirectToRoute('app_suggestion_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('suggestion/new.html.twig', [
                    'suggestion' => $suggestion,
                    'form' => $form,
                ]);

            } else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        }else {
            return $this->redirectToRoute('tbsr_capr_default');
            // throw new AccessDeniedException();
        }
    }

    public function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }

}
