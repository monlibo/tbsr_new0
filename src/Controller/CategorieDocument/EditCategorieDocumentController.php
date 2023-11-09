<?php

namespace App\Controller\CategorieDocument;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\CategorieDocument;
use App\Form\CategorieDocumentType;
use App\Repository\CategorieDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/categorie/document')]
class EditCategorieDocumentController extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}/edit', name: 'app_categorie_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieDocument $categorieDocument, EntityManagerInterface $entityManager, CategorieDocumentRepository $categorieDocumentRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(CategorieDocumentType::class, $categorieDocument);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $categorieDocumentExistant = $categorieDocumentRepository->findOneBy(array('libelle' => $categorieDocument->getLibelle(), 'supprimer' => false));
                    if ($categorieDocumentExistant != null) {
                        if ($categorieDocument->getId() != $categorieDocumentExistant->getId()) {
                            $this->addFlash('error', 'Une categorie ayant le même nom ' . $categorieDocumentExistant->getLibelle() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_categorie_document_edit', array('id' => $categorieDocument->getId()));
                        }
                    }

                    $this->entityManager->flush();
                    $this->saveMouchard("categorieDocument", $categorieDocument->getId(), $categorieDocument->getLibelle(),
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement modifié avec succès ");
                    return $this->redirectToRoute('app_categorie_document_show', ['id' => $categorieDocument->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('categorie_document/edit.html.twig', [
                    'categorieDocument' => $categorieDocument,
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
