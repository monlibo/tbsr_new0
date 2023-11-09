<?php

namespace App\Controller\TypeGraphe;

use App\Entity\TypeGraphe;
use App\Form\TypeGrapheType;
use App\Repository\TypeGrapheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/type/graphe')]
class GetTypeGrapheController extends AbstractController
{


    private AuthorizationCheckerInterface $authorizationChecker;
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }


    #[Route('/{id}', name: 'app_type_graphe_show', methods: ['GET'])]
    public function show(TypeGraphe $typeGraphe): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                return $this->render('type_graphe/show.html.twig', [
                    'typeGraphe' => $typeGraphe,
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
