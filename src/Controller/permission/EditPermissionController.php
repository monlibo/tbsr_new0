<?php

namespace App\Controller\permission;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Permission;
use App\Form\PermissionType;
use App\Repository\PermissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/permission')]
class EditPermissionController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}/edit', name: 'app_permission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Permission $permission, PermissionRepository $permissionRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(PermissionType::class, $permission);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $permissionExistant = $permissionRepository->findOneBy(array('permission' => $permission->getPermission(), 'supprimer' => false));
                    if ($permissionExistant != null) {
                        if ($permission->getId() != $permissionExistant->getId()) {
                            $this->addFlash('error', 'Une permission ayant le même nom ' . $permissionExistant->getPermission() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_permission_edit', array('id' => $permission->getId()));
                        }

                    }

                    $this->entityManager->flush();

                    $this->saveMouchard("permission", $permission->getId(), $permission->getPermission(),
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement modifié avec succès ");
                    return $this->redirectToRoute('app_permission_show', ['id' => $permission->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('permission/edit.html.twig', [
                    'permission' => $permission,
                    'form' => $form,
                ]);
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
