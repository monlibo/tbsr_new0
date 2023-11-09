<?php

namespace App\Controller\Periodicite;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Periodicite;
use App\Form\PeriodiciteType;
use App\Repository\PeriodiciteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/periodicite')]
class AddPeriodiciteController extends AbstractControllerPersonnalisee
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/new', name: 'app_periodicite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PeriodiciteRepository $periodiciteRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $periodicite = new Periodicite();
                $form = $this->createForm(PeriodiciteType::class, $periodicite);
                $form->handleRequest($request);


                if ($form->isSubmitted() && $form->isValid()) {

                    //Ainsi de suite pour les autres autres champs à contrôler
                    $periodiciteExistant = $periodiciteRepository->findOneBy(array('libelle' => $periodicite->getLibelle(), 'supprimer' => false));
                    if ($periodiciteExistant != null) {
                        $this->addFlash('error', 'Une periodicité ayant le même libellé ' . $periodiciteExistant->getLibelle() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_periodicite_new', array('id' => $periodicite->getId()));
                    }

                    //$periodicite->setLibelle()
                    $periodicite->setSupprimer(false);
                    //$periodicite->setAuteur($currentUser->getUserIdentifier());
                    $periodicite->setCreated(new \DateTimeImmutable());

                    $entityManager->persist($periodicite);
                    $entityManager->flush();

                    //Mouchard
                    $this->saveMouchard("periodicite", $periodicite->getId(), $periodicite->getLibelle(),
                        "enregistrement", "profil", "user", "");


                    //Flashbag
                    $this->addFlash('success', "Enregistrement d'une périodicité ". $periodicite->getLibelle() .' effectué avec succès.');

                    return $this->redirectToRoute('app_periodicite_index', [], Response::HTTP_SEE_OTHER);

                }

                return $this->render('periodicite/new.html.twig', [
                    'periodicite' => $periodicite,
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
