<?php

namespace App\Controller\programme;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\ActionBailleur;
use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/programme')]
class DeleteProgrammeController extends AbstractController
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}', name: 'app_programme_delete', methods: ['POST'])]
    public function delete(Request $request, Activite $activite, EntityManagerInterface $entityManager, ActiviteRepository $activiteRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {

                    //Vérification liaison avec d'autres tables
                    $axeUtilise = $this->entityManager->getRepository(Activite::class)->findOneBy(array('libelleActivite' => $activite->getLibelleActivite(), 'supprimer' => false));
                    if ($axeUtilise != null) {
                        $this->addFlash('error', 'Ce programme est relié à une programme. Impossible de procéder à la suppression');
                        return $this->redirectToRoute('app_programme_index');
                    }

                    $activite->setSupprimer(true);
                    $activite->setSupprimerAuteur("user");
                    $activite->setSupprimerDate(new \DateTimeImmutable());
                    $entityManager->flush();
                }

                return $this->redirectToRoute('app_programme_index', [], Response::HTTP_SEE_OTHER);
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
