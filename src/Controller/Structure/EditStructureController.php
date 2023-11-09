<?php

namespace App\Controller\Structure;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Structure;
use App\Form\AnneeType;
use App\Form\StructureType;
use App\Repository\StructureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/structure')]
class EditStructureController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}/edit', name: 'app_structure_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Structure $structure, StructureRepository $structureRepository): Response
    {


        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(StructureType::class, $structure);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $structureExistant = $structureRepository->findOneBy(array('libelle' => $structure->getCode(), 'supprimer' => false));
                    if ($structureExistant != null) {
                        if ($structure->getId() != $structureExistant->getId()) {
                            $this->addFlash('error', 'Une structure ayant le même code ' . $structureExistant->getCode() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_structure_edit', array('id' => $structure->getId()));
                        }

                    }

                    $this->entityManager->flush();

                    $this->saveMouchard("structure", $structure->getId(), $structure->getLibelle(),
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement modifié avec succès ");
                    return $this->redirectToRoute('app_structure_show', ['id' => $structure->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('structure/edit.html.twig', [
                    'structure' => $structure,
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
