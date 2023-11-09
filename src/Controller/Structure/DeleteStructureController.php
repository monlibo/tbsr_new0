<?php

namespace App\Controller\Structure;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Agent;
use App\Entity\Structure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/structure')]
class DeleteStructureController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}', name: 'app_structure_delete', methods: ['POST'])]
    public function delete(Request $request, Structure $structure, EntityManagerInterface $entityManager): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $structure->getId(), $request->request->get('_token'))) {

                    //Vérification liaison avec d'autres tables
                    $structureUtilise = $this->entityManager->getRepository(Agent::class)->findOneBy(array('structure' =>$structure, 'supprimer' => false));
                    if ($structureUtilise != null) {
                        $this->addFlash('error', 'Cette structure est reliée à un agent. Impossible de procéder à la suppression');
                        return $this->redirectToRoute('app_structure_index');
                    }

                    $structure->setSupprimer(true);
                    $structure->setSupprimerAuteur("user");
                    $structure->setSupprimerDate(new \DateTimeImmutable());
                    $this->entityManager->flush();


                    $this->saveMouchard("Structure", $structure->getId(), $structure->getLibelle(),
                        "suppression", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement supprimé avec succès");

                    return $this->redirectToRoute('app_structure_index', [], Response::HTTP_SEE_OTHER);
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
