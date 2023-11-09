<?php

namespace App\Controller\axe;

use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/axe')]
class GetListAxeController extends AbstractController
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/', name: 'app_axe_index', methods: ['GET'])]
    public function index(ActiviteRepository $activiteRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                return $this->render('axe/index.html.twig', [
                    'activites' => $activiteRepository->findAll(),
                ]);
            }else {
                return $this->redirectToRoute('tbsr_capr_default');
            }

            }else {
            return $this->redirectToRoute('tbsr_capr_default');
            // throw new AccessDeniedException();
        }
    }
}
