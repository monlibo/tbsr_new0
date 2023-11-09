<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\AgentRepository;
use App\Repository\UserRepository;
use App\Service\RandomCode;
use App\Service\SendMail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository, AgentRepository $agentRepository, RandomCode $randomCode, SendMail $sendMail): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $matricule = $form->get('agent')->getData()->getMatricule();
            $username = $form->get('username')->getData();
            $agentexiste = $userRepository->findBy(['agent'=> $form->get('agent')->getData()->getIdentifiantAgent()]);
            // recherche si le mail saisi correspond a celui de l'agent selectionné
            $mailetmatriculeagentexiste = $agentRepository->findBy(
                ['email'=> $form->get('mail')->getData(),
                 'matricule'=> $matricule,]);

            if (!$agentexiste) {
                if ($mailetmatriculeagentexiste) {
                    $codeActivtion = $randomCode->generateRandomCode();
                    $user->setCodeActivation($codeActivtion);
                    $user->setPassword(
                        $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('plainPassword')->getData()
                        )
                    );
        
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $messge = "le code d'activation de Mr/Mme ". $username  . " est : <br> <b> " .$codeActivtion."</b>" ;
                    $sendMail->smtpMail('admin@gmail.com',"Code d'activation",$messge);

                    $this->addFlash(
                        'success',
                        'Inscription effectué, veuillez contacter l\'administrateur pour le code de confirmation.');
                   
                    return $this->redirectToRoute('confirmation',['username'=>$username ]); 
                }
                else{

                    $this->addFlash(
                        'error',
                        'Ce mail n\'est pas reconnu pour cet agent'
                     ); 
                     return $this->redirectToRoute('app_register'); 
                }
            }
            elseif($form->get('agent')->getData() == null)
            {
                $this->addFlash(
                   'error',
                   'Cet agent n\'existe pas.'
                ); 
                return $this->redirectToRoute('app_register'); 
            }
            else{

                $this->addFlash(
                   'error',
                   'Cet utilisateur existe déja .'
                );   
                return $this->redirectToRoute('app_register'); 

            }
           
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    #[Route('/confirmation/{username}', name: 'confirmation')]
    public function confirmation (UserRepository $userRepository, Request $request):Response
    {
        
        $username  = $request->attributes->get('username');
        $agentexiste = $userRepository->findBy(['username'=>$username,'enabled'=>false]);
        $agentbesoindeconfirmation = $agentexiste ? true : $this->redirectToRoute('tbsr_capr_default');
        
        
        return $this->render('registration/index.html.twig', [
            'agentbesoindeconfirmation'=>$agentbesoindeconfirmation,
            'username'=>$username,

        ]);

    }


    #[Route('/inscriptionselect', name: 'inscriptionselect')]
    public function inscriptionselect(Request $request):JsonResponse
    {
        $id = $request->get('registration_form_agent');
        return new JsonResponse(['message' => $id]);

    }

    #[Route('/confi/{username}', name: 'confi')]
    public function confi (UserRepository $userRepository, Request $request , EntityManagerInterface $entityManager):Response
    {
        
        $codeActivtion  = $request->request->get('activation');
        $username  = $request->attributes->get('username');
        $user = $userRepository->findOneBy(['username' => $username, 'codeActivation'=>$codeActivtion]);
        if (htmlspecialchars(trim($codeActivtion))) {
            if ($user) {
                
                $user->setEnabled(1);
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    "Votre compte a été bien activé ."
                );
                return $this->redirectToRoute('app_login'); 
            }
            else{

                $this->addFlash(
                    'error',
                    "Ce code ne correspond pas. "
                 );
                return $this->redirectToRoute('confirmation',['username'=>$username]); 
                 
            }
        }
        else
        {
            $this->addFlash(
               'error',
               'Ce champ est vide.'
            );
            return $this->redirectToRoute('confirmation',['username'=>$username]); 
        }

        return $this->redirectToRoute('app_login');

    }
}
