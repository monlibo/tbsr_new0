<?php

namespace App\Controller\bailleur;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Bailleur;
use App\Repository\BailleurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/bailleur')]
class DeleteBailleurController extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}/delete', name: 'app_bailleur_delete', methods: ['POST'])]
    public function delete(Request $request, Bailleur $bailleur, BailleurRepository $bailleurRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $bailleur->getId(), $request->request->get('_token'))) {

                    //Vérification liaison avec d'autres tables
//                    $bailleurUtilise = $this->entityManager->getRepository(ActiviteBailleur::class)->findOneBy(array('bailleur' => $bailleur, 'supprimer' => false));
//                    if ($bailleurUtilise != null) {
//                        $this->addFlash('error', 'Ce bailleur est relié à une activité. Impossible de procéder à la suppression');
//                        return $this->redirectToRoute('app_bailleur_index');
//                    }

                    $bailleur->setSupprimer(true);
                    $bailleur->setSupprimerAuteur("user");
                    $bailleur->setSupprimerDate(new \DateTimeImmutable());
                    $this->entityManager->flush();


                    $this->saveMouchard("Bailleur", $bailleur->getId(), $bailleur->getLibelle(),
                        "suppression", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement supprimé avec succès");

                    return $this->redirectToRoute('app_bailleur_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('bailleur/index.html.twig', [
                    'bailleurs' => $bailleurRepository->findBy(array('supprimer'=>false))]);

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
