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
class EditRoleController extends AbstractController
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}/edit', name: 'app_role_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Role $role, EntityManagerInterface $entityManager, RoleRepository $roleRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(RoleType::class, $role);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $roleExistant = $roleRepository->findOneBy(array('libelle' => $role->getLibelle(), 'supprimer' => false));
                    if ($roleExistant != null) {
                        if ($role->getId() != $roleExistant->getId()) {
                            $this->addFlash('error', 'Un rôle ayant le même nom ' . $roleExistant->getLibelle() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_role_edit', array('id' => $role->getId()));
                        }
                    }

                    //$role->setLastUpdatedAuteur($currentUser->getUserIdentifier());
                    $role->setLastUpdated(new \DateTimeImmutable());
                    $entityManager->flush();

                    $this->saveMouchard("rôle", $role->getId(), $role->getLibelle(),
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement modifié avec succès ");

                    return $this->redirectToRoute('app_role_show', ['id'=>$role->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('role/edit.html.twig', [
                    'role' => $role,
                    'form' => $form,
                ]);


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
