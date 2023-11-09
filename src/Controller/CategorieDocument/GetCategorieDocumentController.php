<?php

namespace App\Controller\CategorieDocument;

use App\Entity\CategorieDocument;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/categorie/document')]
class GetCategorieDocumentController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    #[Route('/{id}', name: 'app_categorie_document_show', methods: ['GET'])]
    public function show(CategorieDocument $categorieDocument): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                return $this->render('categorie_document/show.html.twig', [
                    'categorieDocument' => $categorieDocument,
                ]);
            } else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        } else {
            return $this->redirectToRoute('tbsr_capr_default');
            // throw new AccessDeniedException();
        }

    }


}
