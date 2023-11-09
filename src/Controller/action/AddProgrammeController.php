<?php

namespace App\Controller\action;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Activite;
use App\Form\ActionType;
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

#[Route('/action')]
class AddProgrammeController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_action_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ActiviteRepository $activiteRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $activite = new Activite();
                $form = $this->createForm(ActionType::class, $activite);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    //Ainsi de suite pour les autres autres champs à contrôler
                    $programmeExistant = $activiteRepository->findOneBy(array('libelleActivite' => $activite->getLibelleActivite(), 'supprimer' => false));
                    if ($programmeExistant != null) {
                        $this->addFlash('error', 'Un action ayant le même libellé ' . $programmeExistant->getLibelleActivite() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_action_new', array('id' => $activite->getId()));
                    }

//                    $programmeExistant = $activiteRepository->findOneBy(array('numActivite' => $activite->getNumActivite(), 'supprimer' => false));
//                    if ($programmeExistant != null) {
//                        $this->addFlash('error', 'Un programme ayant le même numéro ' . $programmeExistant->getNumActivite() . ' existe déjà.',
//                        );
//                        return $this->redirectToRoute('app_axe_new', array('id' => $activite->getId()));
//                    }

                    //$activite->setLibelle()
                    $activite->setSupprimer(false);
                    //$activite->setAuteur($currentUser->getUserIdentifier());
                    $activite->setCreated(new \DateTimeImmutable());

                    $entityManager->persist($activite);
                    $entityManager->flush();

                    //Mouchard
                    $this->saveMouchard("action", $activite->getId(), $activite->getLibelleActivite(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', 'Enregistrement de l\'action '. $activite->getLibelleActivite() .' effectué avec succès.');

                    return $this->redirectToRoute('app_action_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('action/new.html.twig', [
                    'activite' => $activite,
                    'form' => $form,
                ]);
            }else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        }else {
            return $this->redirectToRoute('tbsr_capr_default');
            // throw new AccessDeniedException();
        }
    }
    public function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }
}
