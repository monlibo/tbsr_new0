<?php

namespace App\Controller\Rapport;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Rapport;
use App\Form\RapportType;
use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/rapport')]
class DeleteRapportController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}', name: 'app_rapport_delete', methods: ['POST'])]
    public function delete(Request $request, Rapport $rapport): Response
    {


        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $rapport->getId(), $request->request->get('_token'))) {
//
//                    //Vérification liaison avec d'autres tables
//                    $anneeUtilise = $this->entityManager->getRepository(ActiviteAnnee::class)->findOneBy(array('annee' =>$annee, 'supprimer' => false));
//                    if ($anneeUtilise != null) {
//                        $this->addFlash('error', 'Cette annee est reliée à une activité. Impossible de procéder à la suppression');
//                        return $this->redirectToRoute('app_annee_index');
//                    }

                    $rapport->setSupprimer(true);
                    $rapport->setSupprimerAuteur("user");
                    $rapport->setSupprimerDate(new \DateTimeImmutable());
                    $this->entityManager->flush();


                    $this->saveMouchard("Rapport", $rapport->getId(), $rapport->getLibelle(),
                        "suppression", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement supprimé avec succès");

                    return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);
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
