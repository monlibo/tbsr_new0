<?php

namespace App\Controller\TypeGraphe;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\TypeGraphe;
use App\Form\AnneeType;
use App\Form\TypeGrapheType;
use App\Repository\TypeGrapheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/type/graphe')]
class EditTypeGrapheController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}/edit', name: 'app_type_graphe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeGraphe $typeGraphe, TypeGrapheRepository $typeGrapheRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(TypeGrapheType::class, $typeGraphe);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $typeGrapheExistant = $typeGrapheRepository->findOneBy(array('code' => $typeGraphe->getCode(), 'supprimer' => false));
                    if ($typeGrapheExistant != null) {
                        if ($typeGraphe->getId() != $typeGrapheExistant->getId()) {
                            $this->addFlash('error', 'Un type de graphe ayant le même code ' . $typeGrapheExistant->getCode() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_type_graphe_edit', array('id' => $typeGraphe->getId()));
                        }

                    }

                    $this->entityManager->flush();

                    $this->saveMouchard("typeGraphe", $typeGraphe->getId(), $typeGraphe->getCode(),
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement modifié avec succès ");
                    return $this->redirectToRoute('app_type_graphe_show', ['id' => $typeGraphe->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('type_graphe/edit.html.twig', [
                    'typeGraphe' => $typeGraphe,
                    'form' => $form,
                ]);
            } else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        } else {
            return $this->redirectToRoute('tbsr_capr_default');
        }



    }







    public function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }


}
