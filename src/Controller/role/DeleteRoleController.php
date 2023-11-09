<?php

namespace App\Controller\role;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Role;
use App\Form\RoleType;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/role')]
class DeleteRoleController extends AbstractController
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }
    #[Route('/{id}', name: 'app_role_delete', methods: ['POST'])]
    public function delete(Request $request, Role $role, EntityManagerInterface $entityManager, RoleRepository $roleRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $role->getId(), $request->request->get('_token'))) {

                    //Vérification liaison avec d'autres tables
                    $bailleurUtilise = $this->entityManager->getRepository(ActiviteBailleur::class)->findOneBy(array('rôle' => $role, 'supprimer' => false));
                    if ($bailleurUtilise != null) {
                        $this->addFlash('error', 'Ce rôle est relié à une utilisateur. Impossible de procéder à la suppression');
                        return $this->redirectToRoute('app_role_index');
                    }


                    $role->setSupprimer(true);
                    $role->setSupprimerAuteur("user");
                    $role->setSupprimerDate(new \DateTimeImmutable());
                    $entityManager->flush();


                    $this->saveMouchard("Rôle", $role->getId(), $role->getLibelle(),
                        "suppression", "profiluser", "user", "");

                    $this->addFlash('success', "Enregistrement supprimé avec succès");

                    return $this->redirectToRoute('app_role_index', [], Response::HTTP_SEE_OTHER);
                }
                return $this->render('role/index.html.twig', [
                    'roles' => $roleRepository->findAll(),
                ]);
            } else {
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
