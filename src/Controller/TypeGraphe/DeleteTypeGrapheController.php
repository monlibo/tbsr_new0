<?php

namespace App\Controller\TypeGraphe;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\TypeGraphe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/type/graphe')]
class DeleteTypeGrapheController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}', name: 'app_type_graphe_delete', methods: ['POST'])]
    public function delete(Request $request, TypeGraphe $typeGraphe): Response
    {if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

        $currentUser = $this->getUser();

        if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            if ($this->isCsrfTokenValid('delete' . $typeGraphe->getId(), $request->request->get('_token'))) {

                //Vérification liaison avec d'autres tables
                $typeGrapheUtilise = $this->entityManager->getRepository(Rapport::class)->findOneBy(array('typeGraphe' =>$typeGraphe, 'supprimer' => false));
                if ($typeGrapheUtilise != null) {
                    $this->addFlash('error', 'Ce type de graphe est relié à un rapport. Impossible de procéder à la suppression');
                    return $this->redirectToRoute('app_type_graphe_index');
                }

                $typeGraphe->setSupprimer(true);
                $typeGraphe->setSupprimerAuteur("user");
                $typeGraphe->setSupprimerDate(new \DateTimeImmutable());
                $this->entityManager->flush();


                $this->saveMouchard("typeGraphe", $typeGraphe->getId(), $typeGrapheUtilise->getCode(),
                    "suppression", "profiluser", "user", "");


                $this->addFlash('success', "Enregistrement supprimé avec succès");

                return $this->redirectToRoute('app_type_graphe_index', [], Response::HTTP_SEE_OTHER);
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
