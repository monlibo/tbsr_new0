<?php

namespace App\Controller\Periodicite;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Periodicite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/periodicite')]
class DeletePeriodiciteController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}', name: 'app_periodicite_delete', methods: ['POST'])]
    public function delete(Request $request, Periodicite $periodicite, EntityManagerInterface $entityManager): Response
    {


        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $periodicite->getId(), $request->request->get('_token'))) {

                    //Vérification liaison avec d'autres tables
                    $periodiciteUtilise = $this->entityManager->getRepository(Execution::class)->findOneBy(array('periodicite' => $periodicite, 'supprimer' => false));
                    if ($periodiciteUtilise != null) {
                        $this->addFlash('error', 'Cette periodicite est reliée à une execution. Impossible de procéder à la suppression');
                        return $this->redirectToRoute('app_periodicite_index');
                    }

                    $periodicite->setSupprimer(true);
                    $periodicite->setSupprimerAuteur("user");
                    $periodicite->setSupprimerDate(new \DateTimeImmutable());
                    $this->entityManager->flush();


                    $this->saveMouchard("Periodicite", $periodicite->getId(), $periodicite->getLibelle(),
                        "suppression", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement supprimé avec succès");

                    return $this->redirectToRoute('app_periodicite_index', [], Response::HTTP_SEE_OTHER);
                }
            } else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        } else {
            return $this->redirectToRoute('tbsr_capr_default');
        }


    }

    public function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }


}



