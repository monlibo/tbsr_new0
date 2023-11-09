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
class DeleteSuggestionController extends AbstractController
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}', name: 'app_suggestion_delete', methods: ['POST'])]
    public function delete(Request $request, Suggestion $suggestion, EntityManagerInterface $entityManager, SuggestionRepository $suggestionRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $suggestion->getId(), $request->request->get('_token'))) {

                    //Vérification liaison avec d'autres tables
                    $suggestionUtilise = $this->entityManager->getRepository(Suggestion::class)->findOneBy(array('bailleur' => $suggestion, 'supprimer' => false));
                    if ($suggestionUtilise != null) {
                        $this->addFlash('error', 'Ce bailleur est relié à une activité. Impossible de procéder à la suppression');
                        return $this->redirectToRoute('app_bailleur_index');
                    }

                    $suggestion->setSupprimer(true);
                    $suggestion->setSupprimerAuteur("user");
                    $suggestion->setSupprimerDate(new \DateTimeImmutable());
                    $this->entityManager->flush();

                    $this->saveMouchard("Bailleur", $suggestion->getId(), $suggestion->getLibelle(),
                        "suppression", "profiluser", "user", "");

                    $this->addFlash('success', "Suggestion supprimée avec succès");

                    return $this->redirectToRoute('app_suggestion_index', [], Response::HTTP_SEE_OTHER);

                }

                return $this->render('suggestion/index.html.twig', [
                    'suggestions' => $suggestionRepository->findBy(['supprimer'=> false]),
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
