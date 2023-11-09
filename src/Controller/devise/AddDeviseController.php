<?php

namespace App\Controller\devise;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Devise;
use App\Form\DeviseType;
use App\Repository\DeviseRepository;
use App\Service\FormControl;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/devise')]
class AddDeviseController   extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_devise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DeviseRepository $deviseRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $devise = new Devise();
                $form = $this->createForm(DeviseType::class, $devise);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                        
                    //Ainsi de suite pour les autres autres champs à contrôler
                    $deviseExistant = $deviseRepository->findOneBy(array('code' => $devise->getCode(), 'supprimer' => false));
                    if ($form->get('taux')->getData() >= 1 && $form->get('taux')->getData() <= 100) {
                        if ($deviseExistant != null) {
                            $this->addFlash('error', 'Une devise ayant le même code ' . $deviseExistant->getCode() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_devise_new', array('id' => $devise->getId()));
                        }
                        //$devise->setLibelle()
                        $devise->setSupprimer(false);
                        //$devise->setAuteur($currentUser->getUserIdentifier());
                        $devise->setCreated(new \DateTimeImmutable());

                        $this->entityManager->persist($devise);
                        $this->entityManager->flush();

                        $this->saveMouchard("devise", $devise->getId(), $devise->getLibelle(),
                            "enregistrement", "profil", "user", "");

                        //Flashbag
                        $this->addFlash('success', 'Enregistrement du devise '. $devise->getLibelle() .' effectué avec succès.');
                        return $this->redirectToRoute('app_devise_index', [], Response::HTTP_SEE_OTHER);
                    }
                    else
                    {
                                $this->addFlash('error', 'Un taux doit etre entre 0 et 100 ');
                        return $this->redirectToRoute('app_devise_new', array('id' => $devise->getId()));
                    }
                }
                return $this->render('devise/new.html.twig', [
                    'devise' => $devise,
                    'form' => $form,
                ]);
            } else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        } else {
            return $this->redirectToRoute('tbsr_capr_default');
            // throw new AccessDeniedException();
        }
    }


    public function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }

}
