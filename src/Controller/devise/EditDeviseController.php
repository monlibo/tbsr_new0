<?php

namespace App\Controller\devise;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Devise;
use App\Form\DeviseType;
use App\Repository\DeviseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/devise')]
class EditDeviseController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}/edit', name: 'app_devise_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Devise $devise, DeviseRepository $deviseRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(DeviseType::class, $devise);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $deviseExistant = $deviseRepository->findOneBy(array('code' => $devise->getCode(), 'supprimer' => false));
                    if ($form->get('taux')->getData() >= 1 && $form->get('taux')->getData() <= 100) {
                        if ($deviseExistant != null) {
                            if ($devise->getId() != $deviseExistant->getId()) {
                                $this->addFlash('error', 'Une devise ayant le même nom ' . $deviseExistant->getLibelle() . ' existe déjà.',
                                );
                                return $this->redirectToRoute('app_devise_edit', array('id' => $devise->getId()));
                            }
                        }
                        $this->entityManager->flush();
                        $this->saveMouchard("devise", $devise->getId(), $devise->getLibelle(),
                            "modification", "profiluser", "user", "");
                        $this->addFlash('success', "Enregistrement modifié avec succès ");
                        return $this->redirectToRoute('app_devise_index', ['id' => $devise->getId()], Response::HTTP_SEE_OTHER);
                    }
                    else
                    {
                        $this->addFlash('error', 'Un taux doit etre entre 0 et 100 ');
                        return $this->redirectToRoute('app_devise_edit', array('id' => $devise->getId()));
                    }
                }
                return $this->render('devise/edit.html.twig', [
                    'devise' => $devise,
                    'form' => $form,
                ]);
            } else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        } else {
            return $this->redirectToRoute('tbsr_capr_default');
        }


    }


    public
    function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }

}
