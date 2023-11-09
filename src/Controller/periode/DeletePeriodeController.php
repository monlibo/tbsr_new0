<?php

namespace App\Controller\periode;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Periode;
use App\Form\PeriodeType;
use App\Repository\PeriodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/periode')]
class DeletePeriodeController extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}/delete', name: 'app_periode_delete', methods: ['POST'])]
    public function delete(Request $request, Periode $periode): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $periode->getId(), $request->request->get('_token'))) {
                    $periodeintervalle = $periode->getDateDebut()." au ".$periode->getDateFin();
                    
                    //Vérification liaison avec d'autres tables
                    $periodeUtilise = $this->entityManager->getRepository(ActivitePeriode::class)->findOneBy(array('periode' =>$periode, 'supprimer' => false));
                    if ($periodeUtilise != null) {
                        $this->addFlash('error', 'Ce periode est relié à une activité. Impossible de procéder à la suppression');
                        return $this->redirectToRoute('app_periode_index');
                    }

                    $periode->setSupprimer(true);
                    $periode->setSupprimerAuteur("user");
                    $periode->setSupprimerDate(new \DateTimeImmutable());
                    $this->entityManager->flush();


                    $this->saveMouchard("Periode", $periode->getId(),  $periodeintervalle,
                        "suppression", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement supprimé avec succès");

                    return $this->redirectToRoute('app_periode_index', [], Response::HTTP_SEE_OTHER);
                }
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
