<?php

namespace App\Controller\TypeDonnee;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\TypeDonnee;
use App\Form\TypeDonneeType;
use App\Repository\TypeDonneeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/typeDonnee')]
class EditTypeDonneeController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}/edit', name: 'app_typeDonnee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeDonnee $typeDonnee, TypeDonneeRepository $typeDonneeRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(TypeDonneeType::class, $typeDonnee);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $typeDonneeExistant = $typeDonneeRepository->findOneBy(array('code' => $typeDonnee->getCode(), 'supprimer' => false));
                    if ($typeDonneeExistant != null) {
                        if ($typeDonnee->getId() != $typeDonneeExistant->getId()) {
                            $this->addFlash('error', 'Un type de donné ayant le même nom ' . $typeDonneeExistant->getLibelle() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_typeDonnee_edit', array('id' => $typeDonnee->getId()));
                        }

                    }

                    $this->entityManager->flush();

                    $this->saveMouchard("typeDonnee", $typeDonnee->getId(), $typeDonnee->getLibelle(),
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement modifié avec succès ");
                    return $this->redirectToRoute('app_typeDonnee_index', ['id' => $typeDonnee->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('typeDonnee/edit.html.twig', [
                    'typeDonnee' => $typeDonnee,
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
