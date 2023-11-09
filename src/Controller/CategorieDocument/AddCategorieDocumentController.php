<?php

namespace App\Controller\CategorieDocument;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Annee;
use App\Entity\CategorieDocument;
use App\Form\AnneeType;
use App\Form\CategorieDocumentType;
use App\Repository\CategorieDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/categorie/document')]
class AddCategorieDocumentController extends AbstractControllerPersonnalisee
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/new', name: 'app_categorie_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CategorieDocumentRepository $categorieDocumentRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $categorieDocument = new CategorieDocument();
                $form = $this->createForm(CategorieDocumentType::class, $categorieDocument);
                $form->handleRequest($request);


                if ($form->isSubmitted() && $form->isValid()) {
                    //Ainsi de suite pour les autres autres champs à contrôler
                    $categorieExistant = $categorieDocumentRepository->findOneBy(array('libelle' => $categorieDocument->getLibelle(), 'supprimer' => false));
                    if ($categorieExistant != null) {
                        $this->addFlash('error', 'Une catégorie de document ayant le même libellé ' . $categorieExistant->getLibelle() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_categorie_document_new', array('id' => $categorieDocument->getId()));
                    }

                    //$categorieDocument->setLibelle()
                    $categorieDocument->setSupprimer(false);
                    //$categorieDocument->setAuteur($currentUser->getUserIdentifier());
                    $categorieDocument->setCreated(new \DateTimeImmutable());

                    $entityManager->persist($categorieDocument);
                    $entityManager->flush();


                    //Mouchard
                    $this->saveMouchard("categorieDocument", $categorieDocument->getId(), $categorieDocument->getLibelle(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', "Enregistrement d'une categorie de document " . $categorieDocument->getLibelle() . ' effectué avec succès.');
                    return $this->redirectToRoute('app_categorie_document_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('categorie_document/new.html.twig', [
                    'categorieDocument' => $categorieDocument,
                    'form' => $form,
                ]);


            } else {
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
