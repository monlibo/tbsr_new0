<?php

namespace App\Controller\Rapport;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Rapport;
use App\Form\RapportType;
use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/rapport')]
class AddRapportController extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/new', name: 'app_rapport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, RapportRepository $rapportRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $rapport = new Rapport();
                $form = $this->createForm(RapportType::class, $rapport);
                $form->handleRequest($request);


                if ($form->isSubmitted() && $form->isValid()) {
                    //Ainsi de suite pour les autres autres champs à contrôler
                    $rapportExistant = $rapportRepository->findOneBy(array('libelle' => $rapport->getLibelle(), 'supprimer' => false));
                    if ($rapportExistant != null) {
                        $this->addFlash('error', 'Un rapport ayant le même libellé ' . $rapportExistant->getLibelle() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_rapport_new', array('id' => $rapport->getId()));
                    }

                    //$rapport->setLibelle()
                    $rapport->setSupprimer(false);
                    //$rapport->setAuteur($currentUser->getUserIdentifier());
                    $rapport->setCreated(new \DateTimeImmutable());


                    $entityManager->persist($rapport);
                    $entityManager->flush();

                    //Mouchard
                    $this->saveMouchard("rapport", $rapport->getId(), $rapport->getLibelle(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', "Enregistrement d'un rapport ". $rapport->getLibelle() .' effectué avec succès.');

                    return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);

                }
                return $this->render('rapport/new.html.twig', [
                    'rapport' => $rapport,
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
