<?php

namespace App\Controller\fonction;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Fonction;
use App\Form\FonctionType;
use App\Repository\FonctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/fonction')]
class AddFonctionController   extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_fonction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FonctionRepository $fonctionRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $fonction = new Fonction();
                $form = $this->createForm(FonctionType::class, $fonction);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    //Ainsi de suite pour les autres autres champs à contrôler
                    $fonctionExistant = $fonctionRepository->findOneBy(array('code' => $fonction->getCode(), 'supprimer' => false));
                    if ($fonctionExistant != null) {
                        $this->addFlash('error', 'Un fonction ayant le même code ' . $fonctionExistant->getCode() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_fonction_new', array('id' => $fonction->getId()));
                    }


                    //$fonction->setLibelle()
                    $fonction->setSupprimer(false);
                    //$fonction->setAuteur($currentUser->getUserIdentifier());
                    $fonction->setCreated(new \DateTimeImmutable());

                    $this->entityManager->persist($fonction);
                    $this->entityManager->flush();


                    //Mouchard
                    $this->saveMouchard("fonction", $fonction->getId(), $fonction->getLibelle(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', 'Enregistrement du fonction '. $fonction->getLibelle() .' effectué avec succès.');
                    return $this->redirectToRoute('app_fonction_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('fonction/new.html.twig', [
                    'fonction' => $fonction,
                    'form' => $form,
                ]);
            } else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        } else {
            return $this->redirectToRoute('tbsr_capr_default');
            // throw new AccessDeniedException();
        }
    }


    public function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }

}
