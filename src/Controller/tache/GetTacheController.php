<?php

namespace App\Controller\tache;

use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/tache')]
class GetTacheController extends AbstractController
{
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    #[Route('/{id}', name: 'app_tache_show', methods: ['GET'])]
    public function show(Activite $activite): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {

                return $this->render('tache/show.html.twig', [
                    'activite' => $activite,
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
