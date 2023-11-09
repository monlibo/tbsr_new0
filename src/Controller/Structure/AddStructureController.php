<?php

namespace App\Controller\Structure;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Annee;
use App\Entity\Structure;
use App\Form\AnneeType;
use App\Form\StructureType;
use App\Repository\StructureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/structure')]
class AddStructureController extends AbstractControllerPersonnalisee
{


    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/new', name: 'app_structure_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, StructureRepository $structureRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $structure = new Structure();
                $form = $this->createForm(StructureType::class, $structure);
                $form->handleRequest($request);


                if ($form->isSubmitted() && $form->isValid()) {
                    //Ainsi de suite pour les autres autres champs à contrôler
                    $structureExistant = $structureRepository->findOneBy(array('code' => $structure->getCode(), 'supprimer' => false));
                    if ($structureExistant != null) {
                        $this->addFlash('error', 'Une structure ayant le même code ' . $structureExistant->getCode() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_structure_new', array('id' => $structure->getId()));
                    }

                    //$structure->setLibelle()
                    $structure->setSupprimer(false);
                    //$structure->setAuteur($currentUser->getUserIdentifier());
                    $structure->setCreated(new \DateTimeImmutable());


                    $entityManager->persist($structure);
                    $entityManager->flush();

                    //Mouchard
                    $this->saveMouchard("structure", $structure->getId(), $structure->getCode(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', "Enregistrement d'une structure ". $structure->getLibelle() .' effectué avec succès.');

                    return $this->redirectToRoute('app_structure_index', [], Response::HTTP_SEE_OTHER);

                }
                return $this->render('structure/new.html.twig', [
                    'structure' => $structure,
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
