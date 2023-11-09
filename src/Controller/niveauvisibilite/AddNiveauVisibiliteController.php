<?php

namespace App\Controller\niveauvisibilite;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\NiveauVisibilite;
use App\Form\NiveauVisibiliteType;
use App\Repository\NiveauVisibiliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/niveauvisibilite')]
class AddNiveauVisibiliteController extends AbstractController
{


    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;


    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_niveauvisibilite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, NiveauVisibiliteRepository $niveauVisibiliteRepository): Response
    {


        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $niveauVisibilite = new NiveauVisibilite();
                $form = $this->createForm(NiveauVisibiliteType::class, $niveauVisibilite);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {


                    //Ainsi de suite pour les autres autres champs à contrôler
                    $bailleurExistant = $niveauVisibiliteRepository->findOneBy(array('code' => $niveauVisibilite->getCode(), 'supprimer' => false));
                    if ($bailleurExistant != null) {
                        $this->addFlash('error', 'Un niveau de visibilité ayant le même code ' . $bailleurExistant->getCode() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_niveauvisibilite_new', array('id' => $niveauVisibilite->getId()));
                    }

                    //$niveauVisibilite->setLibelle()
                    $niveauVisibilite->setSupprimer(false);
                    //$bailleur->setAuteur($currentUser->getUserIdentifier());
                    $niveauVisibilite->setCreated(new \DateTimeImmutable());

                    $entityManager->persist($niveauVisibilite);
                    $entityManager->flush();


                    //Mouchard
                    $this->saveMouchard("bailleur", $niveauVisibilite->getId(), $niveauVisibilite->getLibelle(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', 'Enregistrement du niveau de visibilité '. $niveauVisibilite->getLibelle() .' effectué avec succès.');
                    return $this->redirectToRoute('app_niveauvisibilite_index', [], Response::HTTP_SEE_OTHER);

                }
                return $this->render('niveauvisibilite/new.html.twig', [
                    'niveau_visibilite' => $niveauVisibilite,
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
