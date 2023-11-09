<?php

namespace App\Controller\typeactivite;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\TypeActivite;
use App\Form\TypeActiviteType;
use App\Repository\TypeActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/type/activite')]
class AddTypeActiviteController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_type_activite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, TypeActiviteRepository $typeActiviteRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $typeActivite = new TypeActivite();
                $form = $this->createForm(TypeActiviteType::class, $typeActivite);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    //Ainsi de suite pour les autres autres champs à contrôler
                    $typeactiviteExistant = $typeActiviteRepository->findOneBy(array('libelle' => $typeActivite->getLibelle(), 'supprimer' => false));
                    if ($typeactiviteExistant != null) {
                        $this->addFlash('error', 'Un type d\'activité ayant le même libellé ' . $typeactiviteExistant->getLibelle() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_type_activite_new', array('id' => $typeActivite->getId()));
                    }

                    //dd('bien');

                    //$typeActivite->setLibelle()
                    $typeActivite->setSupprimer(false);
                    //$typeActivite->setAuteur($currentUser->getUserIdentifier());
                    $typeActivite->setCreated(new \DateTimeImmutable());

                    $entityManager->persist($typeActivite);
                    $entityManager->flush();


                    //Mouchard
                    $this->saveMouchard("bailleur", $typeActivite->getId(), $typeActivite->getLibelle(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', 'Enregistrement du type d\'activité '. $typeActivite->getLibelle() .' effectué avec succès.');
                    return $this->redirectToRoute('app_type_activite_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('type_activite/new.html.twig', [
                    'type_activite' => $typeActivite,
                    'form' => $form,
                ]);
            } else {
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
