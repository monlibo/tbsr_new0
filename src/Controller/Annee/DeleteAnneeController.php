<?php

namespace App\Controller\Annee;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Annee;
use App\Form\AnneeType;
use App\Repository\AnneeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/annee')]
class DeleteAnneeController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}/delete', name: 'app_annee_delete', methods: ['POST'])]
    public function delete(Request $request, Annee $annee): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $annee->getId(), $request->request->get('_token'))) {
//
//                    //Vérification liaison avec d'autres tables
//                    $anneeUtilise = $this->entityManager->getRepository(ActiviteAnnee::class)->findOneBy(array('annee' =>$annee, 'supprimer' => false));
//                    if ($anneeUtilise != null) {
//                        $this->addFlash('error', 'Cette annee est reliée à une activité. Impossible de procéder à la suppression');
//                        return $this->redirectToRoute('app_annee_index');
//                    }

                    $annee->setSupprimer(true);
                    $annee->setSupprimerAuteur("user");
                    $annee->setSupprimerDate(new \DateTimeImmutable());
                    $this->entityManager->flush();


                    $this->saveMouchard("Annee", $annee->getId(), $annee->getLibelle(),
                        "suppression", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement supprimé avec succès");

                    return $this->redirectToRoute('app_annee_index', [], Response::HTTP_SEE_OTHER);
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
