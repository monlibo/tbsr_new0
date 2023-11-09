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
class AddRoleController extends AbstractController
{


    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_role_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, RoleRepository $roleRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $role = new Role();
                $form = $this->createForm(RoleType::class, $role);
                $form->handleRequest($request);


                if ($form->isSubmitted() && $form->isValid()) {

                    //Ainsi de suite pour les autres autres champs à contrôler
                    $roleExistant = $roleRepository->findOneBy(array('r$ole' => $role->getLibelle(), 'supprimer' => false));
                    if ($roleExistant != null) {
                        $this->addFlash('error', 'Un rôle ayant le même libellé ' . $roleExistant->getLibelle() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_role_new', array('id' => $role->getId()));
                    }

                    //$role->setLibelle()
                    $role->setSupprimer(false);
                    //$role->setAuteur($currentUser->getUserIdentifier());
                    $role->setCreated(new \DateTimeImmutable());

                    $entityManager->persist($role);
                    $entityManager->flush();

                    //Mouchard
                    $this->saveMouchard("Rôle", $role->getId(), $role->getLibelle(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', 'Enregistrement du rôle '. $role->getLibelle() .' effectué avec succès.');

                    return $this->redirectToRoute('app_role_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('role/new.html.twig', [
                    'role' => $role,
                    'form' => $form,
                ]);

            }else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        }else {
            return $this->redirectToRoute('tbsr_capr_default');
            // throw new AccessDeniedException();
        }
    }

    public function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }
}
