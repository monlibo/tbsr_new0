<?php

namespace App\Controller\niveauvisibilite;

use App\Entity\NiveauVisibilite;
use App\Form\NiveauVisibiliteType;
use App\Repository\NiveauVisibiliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/niveauvisibilite')]
class GetListNiveauVisibiliteController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/', name: 'app_niveauvisibilite_index', methods: ['GET'])]
    public function index(NiveauVisibiliteRepository $niveauVisibiliteRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                return $this->render('niveauvisibilite/index.html.twig', [
                    'niveau_visibilites' => $niveauVisibiliteRepository->findBy(['supprimer'=> false]),
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
