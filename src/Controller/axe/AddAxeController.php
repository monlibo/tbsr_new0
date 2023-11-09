<?php

namespace App\Controller\axe;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Form\AxeType;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/axe')]
class AddAxeController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_axe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ActiviteRepository $activiteRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $activite = new Activite();
                $form = $this->createForm(AxeType::class, $activite);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    //Ainsi de suite pour les autres autres champs à contrôler
                    $axeExistant = $activiteRepository->findOneBy(array('libelleActivite' => $activite->getLibelleActivite(), 'supprimer' => false));
                    if ($axeExistant != null) {
                        $this->addFlash('error', 'Un axe ayant le même libellé ' . $axeExistant->getLibelleActivite() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_axe_new', array('id' => $activite->getId()));
                    }

                    $axeExistant = $activiteRepository->findOneBy(array('numActivite' => $activite->getNumActivite(), 'supprimer' => false));
                    if ($axeExistant != null) {
                        $this->addFlash('error', 'Un axe ayant le même numéro ' . $axeExistant->getNumActivite() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_axe_new', array('id' => $activite->getId()));
                    }


                    //$activite->setLibelle()
                    $activite->setSupprimer(false);
                    //$activite->setAuteur($currentUser->getUserIdentifier());
                    $activite->setCreated(new \DateTimeImmutable());

                    $entityManager->persist($activite);
                    $entityManager->flush();


                    //Mouchard
                    $this->saveMouchard("axe", $activite->getId(), $activite->getLibelleActivite(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', 'Enregistrement de l\'axe '. $activite->getLibelleActivite() .' effectué avec succès.');

                    return $this->redirectToRoute('app_axe_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('axe/new.html.twig', [
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
