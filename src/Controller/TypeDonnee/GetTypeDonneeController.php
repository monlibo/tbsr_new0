<?php

namespace App\Controller\TypeDonnee;


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
class GetTypeDonneeController extends AbstractController
{
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    #[Route('/show/{id}', name: 'app_typeDonnee_show', methods: ['GET'])]
    public function show(TypeDonnee $typeDonnee): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                return $this->render('typeDonnee/show.html.twig', [
                    'typeDonnee' => $typeDonnee,
                ]);
            } else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        } else {
            return $this->redirectToRoute('tbsr_capr_default');
            // throw new AccessDeniedException();
        }


        return $this->render('add_typeDonnee/show.html.twig', [
            'typeDonnee' => $typeDonnee,
        ]);
    }

}
