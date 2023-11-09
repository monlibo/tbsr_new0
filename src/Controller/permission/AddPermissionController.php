<?php

namespace App\Controller\permission;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Permission;
use App\Form\PermissionType;
use App\Repository\PermissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/permission')]
class AddPermissionController   extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_permission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PermissionRepository $permissionRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $permission = new Permission();
                $form = $this->createForm(PermissionType::class, $permission);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    //Ainsi de suite pour les autres autres champs à contrôler
                    $permissionExistant = $permissionRepository->findOneBy(array('permission' => $permission->getPermission(), 'supprimer' => false));
                    if ($permissionExistant != null) {
                        $this->addFlash('error', 'Une permission ayant le même libellé ' . $permissionExistant->getPermission() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_permission_new', array('id' => $permission->getId()));
                    }


                    //$permission->setLibelle()
                    $permission->setSupprimer(false);
                    //$permission->setAuteur($currentUser->getUserIdentifier());
                    $permission->setCreated(new \DateTimeImmutable());

                    $this->entityManager->persist($permission);
                    $this->entityManager->flush();


                    //Mouchard
                    $this->saveMouchard("permission", $permission->getId(), $permission->getPermission(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', 'Enregistrement du permission '. $permission->getPermission() .' effectué avec succès.');
                    return $this->redirectToRoute('app_permission_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('permission/new.html.twig', [
                    'permission' => $permission,
                    'form' => $form,
                ]);
            } else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        } else {
            return $this->redirectToRoute('tbsr_capr_default');
            // throw new AccessDeniedException();
        }
    }


    public function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }

}
