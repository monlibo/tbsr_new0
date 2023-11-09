<?php

namespace App\Controller\fonction;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Fonction;
use App\Form\FonctionType;
use App\Repository\FonctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/fonction')]
class DeleteFonctionController extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}/delete', name: 'app_fonction_delete', methods: ['POST'])]
    public function delete(Request $request, Fonction $fonction): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $fonction->getId(), $request->request->get('_token'))) {

                    //Vérification liaison avec d'autres tables
                    $fonctionUtilise = $this->entityManager->getRepository(ActiviteFonction::class)->findOneBy(array('fonction' =>$fonction, 'supprimer' => false));
                    if ($fonctionUtilise != null) {
                        $this->addFlash('error', 'Ce fonction est relié à une activité. Impossible de procéder à la suppression');
                        return $this->redirectToRoute('app_fonction_index');
                    }

                    $fonction->setSupprimer(true);
                    $fonction->setSupprimerAuteur("user");
                    $fonction->setSupprimerDate(new \DateTimeImmutable());
                    $this->entityManager->flush();


                    $this->saveMouchard("Fonction", $fonction->getId(), $fonction->getLibelle(),
                        "suppression", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement supprimé avec succès");

                    return $this->redirectToRoute('app_fonction_index', [], Response::HTTP_SEE_OTHER);
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
