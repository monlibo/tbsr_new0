<?php
namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils , UserRepository $userRepository, Request $request): Response
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $this->addFlash(
           'error',
           $request->query->get('error')
        );
        
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
       
    }

    #[Route(path: '/addflashandredirecte/{addFlashType}/{addFlashMessage}/{targetRouteAfterAddFlash}', name: 'addflashandredirecte')]
    public function addFlashAndRedirecte($addFlashType, $addFlashMessage, $targetRouteAfterAddFlash): Response
    {
        $this->addFlash(
           $addFlashType,
           $addFlashMessage
        );
        return $this->redirectToRoute($targetRouteAfterAddFlash);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        //return $this->redirectToRoute($targetRouteAfterAddFlash);
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}