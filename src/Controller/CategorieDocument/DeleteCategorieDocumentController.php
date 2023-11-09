<?php

namespace App\Controller\CategorieDocument;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\CategorieDocument;
use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/categorie/document')]
class DeleteCategorieDocumentController extends AbstractControllerPersonnalisee
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}', name: 'app_categorie_document_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieDocument $categorieDocument): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $categorieDocument->getId(), $request->request->get('_token'))) {

                    //Vérification liaison avec d'autres tables
                    $categorieDocumentUtilise = $this->entityManager->getRepository(Document::class)->findOneBy(array('categorieDocument' =>$categorieDocument, 'supprimer' => false));
                    if ($categorieDocumentUtilise != null) {
                        $this->addFlash('error', 'Cette categorie est reliée à un document. Impossible de procéder à la suppression');
                        return $this->redirectToRoute('app_categorie_document_index');
                    }

                    $categorieDocument->setSupprimer(true);
                    $categorieDocument->setSupprimerAuteur("user");
                    $categorieDocument->setSupprimerDate(new \DateTimeImmutable());
                    $this->entityManager->flush();


                    $this->saveMouchard("categorieDocument", $categorieDocument->getId(), $categorieDocumentUtilise->getLibelle(),
                        "suppression", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement supprimé avec succès");

                    return $this->redirectToRoute('app_categorie_document_index', [], Response::HTTP_SEE_OTHER);
                }
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
