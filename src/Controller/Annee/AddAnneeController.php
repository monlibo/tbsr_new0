<?php

namespace App\Controller\Annee;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Annee;
use App\Form\AnneeType;
use App\Repository\AnneeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/annee')]
class AddAnneeController extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_annee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, AnneeRepository $anneeRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $annee = new Annee();
                $form = $this->createForm(AnneeType::class, $annee);
                $form->handleRequest($request);


                if ($form->isSubmitted() && $form->isValid()) {
                    //Ainsi de suite pour les autres autres champs à contrôler
                    $anneeExistant = $anneeRepository->findOneBy(array('libelle' => $annee->getLibelle(), 'supprimer' => false));
                    if ($anneeExistant != null) {
                        $this->addFlash('error', 'Une année ayant le même libellé ' . $anneeExistant->getLibelle() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_annee_new', array('id' => $annee->getId()));
                    }

                    //$annee->setLibelle()
                    $annee->setSupprimer(false);
                    //$annee->setAuteur($currentUser->getUserIdentifier());
                    $annee->setCreated(new \DateTimeImmutable());


                    $entityManager->persist($annee);
                    $entityManager->flush();

                    //Mouchard
                    $this->saveMouchard("année", $annee->getId(), $annee->getLibelle(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', "Enregistrement d'une année ". $annee->getLibelle() .' effectué avec succès.');

                    return $this->redirectToRoute('app_annee_index', [], Response::HTTP_SEE_OTHER);

                }
                return $this->render('annee/new.html.twig', [
                    'annee' => $annee,
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
