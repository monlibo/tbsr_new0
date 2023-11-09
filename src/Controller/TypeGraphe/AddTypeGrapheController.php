<?php

namespace App\Controller\TypeGraphe;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Annee;
use App\Entity\TypeGraphe;
use App\Form\AnneeType;
use App\Form\TypeGrapheType;
use App\Repository\TypeGrapheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/type/graphe')]
class AddTypeGrapheController extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/new', name: 'app_type_graphe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, TypeGrapheRepository $typeGrapheRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $typeGraphe = new TypeGraphe();
                $form = $this->createForm(TypeGrapheType::class, $typeGraphe);
                $form->handleRequest($request);


                if ($form->isSubmitted() && $form->isValid()) {
                    //Ainsi de suite pour les autres autres champs à contrôler
                    $typeGrapheExistant = $typeGrapheRepository->findOneBy(array('code' => $typeGraphe->getCode(), 'supprimer' => false));
                    if ($typeGrapheExistant != null) {
                        $this->addFlash('error', 'Un type de graphe ayant le même code ' . $typeGrapheExistant->getCode() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_type_graphe_new', array('id' => $typeGraphe->getId()));
                    }

                    //$typeGraphe->setCode()
                    $typeGraphe->setSupprimer(false);
                    //$typeGraphe->setAuteur($currentUser->getUserIdentifier());
                    $typeGraphe->setCreated(new \DateTimeImmutable());


                    $entityManager->persist($typeGraphe);
                    $entityManager->flush();

                    //Mouchard
                    $this->saveMouchard("année", $typeGraphe->getId(), $typeGraphe->getCode(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', "Enregistrement d'un type de graphe ". $typeGraphe->getCode() .' effectué avec succès.');

                    return $this->redirectToRoute('app_type_graphe_index', [], Response::HTTP_SEE_OTHER);

                }
                return $this->render('type_graphe/new.html.twig', [
                    'typeGraphe' => $typeGraphe,
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
