<?php

namespace App\Controller\fonction;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Fonction;
use App\Form\FonctionType;
use App\Repository\FonctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/fonction')]
class EditFonctionController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}/edit', name: 'app_fonction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fonction $fonction, FonctionRepository $fonctionRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(FonctionType::class, $fonction);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $fonctionExistant = $fonctionRepository->findOneBy(array('code' => $fonction->getCode(), 'supprimer' => false));
                    if ($fonctionExistant != null) {
                        if ($fonction->getId() != $fonctionExistant->getId()) {
                            $this->addFlash('error', 'Un fonction ayant le même nom ' . $fonctionExistant->getCode() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_fonction_edit', array('id' => $fonction->getId()));
                        }

                    }

                    $this->entityManager->flush();

                    $this->saveMouchard("fonction", $fonction->getId(), $fonction->getLibelle(),
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement modifié avec succès ");
                    return $this->redirectToRoute('app_fonction_index', ['id' => $fonction->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('fonction/edit.html.twig', [
                    'fonction' => $fonction,
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
