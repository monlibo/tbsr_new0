<?php

namespace App\Controller\programme;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Form\AxeType;
use App\Form\ProgrammeType;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/programme')]
class EditProgrammeController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}/edit', name: 'app_programme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activite $activite, EntityManagerInterface $entityManager, ActiviteRepository $activiteRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(ProgrammeType::class, $activite);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $axeExistant = $activiteRepository->findOneBy(array('libelleActivite' => $activite->getLibelleActivite(), 'supprimer' => false));
                    if ($axeExistant != null) {
                        if ($activite->getId() != $axeExistant->getId()) {
                            $this->addFlash('error', 'Un programme ayant le même libelle ' . $axeExistant->getLibelleActivite() . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_programme_edit', array('id' => $activite->getId()));
                        }
                    }
                    //$activite->setLastUpdatedAuteur($currentUser->getUserIdentifier());
                    $activite->setLastUpdated(new \DateTimeImmutable());
                    $entityManager->flush();

                    return $this->redirectToRoute('app_programme_show', ['id'=>$activite->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('programme/edit.html.twig', [
                    'activite' => $activite,
                    'form' => $form,
                ]);

            }else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        }else {
            return $this->redirectToRoute('tbsr_capr_default');
        }
    }

    public
    function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }
}
