<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;


class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    private $entityManager;
    private $abstractController;
    private $userRepository;
    private $tokenStorage;

    public function __construct(private UrlGeneratorInterface $urlGenerator, EntityManagerInterface $entityManager ,TokenStorageInterface $tokenStorage,  UserRepository $userRepository )
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->tokenStorage = $tokenStorage;
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('username', '');
        $request->getSession()->set(Security::LAST_USERNAME, $username);       
        return new Passport(
            new UserBadge($username),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName ,): ?Response
    {
        $username = $request->request->get('username');
        $userEnable = $this->userRepository->findBy(array('username' => $username, 'enabled'=>true));
        $userpremiereconnexionestfalse = $this->userRepository->findBy(array('username' => $username, 'premiereConnexion'=>false,'datePremiereConnexion'=>null ));
        if ($userEnable == false) {
            $this->tokenStorage->setToken(null);
            $response = "Vous n'avez pas les autorisations nécessaires. Veuillez confirmer votre <a href='/confirmation/".$username."'>compte ici</a> ou contacter l\'administrateur.";

            return new RedirectResponse(
                $this->urlGenerator->generate('app_login', ['error' => $response])
            );
        }
        elseif($userpremiereconnexionestfalse)
        {
            foreach ($userEnable as $user) {
                $user->setPremiereConnexion(1);
                $user->setDatePremiereConnexion(new \DateTime('now'));
                $user->setLastLogin(new \DateTime('now'));
                $this->entityManager->flush($user);
            }
        }else{
            foreach ($userEnable as $user) {
                $user->setLastLogin(new \DateTime('now'));
                $this->entityManager->flush($user);
            }
        }
        
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('app_dashboard'));
        //throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
