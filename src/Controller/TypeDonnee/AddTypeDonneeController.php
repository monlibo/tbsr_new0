<?php

namespace App\Controller\TypeDonnee;
use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\TypeDonnee;
use App\Form\TypeDonneeType;
use App\Repository\TypeDonneeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/typeDonnee')]
class AddTypeDonneeController   extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_typeDonnee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeDonneeRepository $typeDonneeRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $typeDonnee = new TypeDonnee();
                $form = $this->createForm(TypeDonneeType::class, $typeDonnee);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    //Ainsi de suite pour les autres autres champs à contrôler
                    $typeDonneeExistant = $typeDonneeRepository->findOneBy(array('code' => $typeDonnee->getCode(), 'supprimer' => false));
                    if ($typeDonneeExistant != null) {
                        $this->addFlash('error', 'Ce type de donnée ' . $typeDonneeExistant->getCode() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_typeDonnee_new', array('id' => $typeDonnee->getId()));
                    }


                    //$typeDonnee->setLibelle()
                    $typeDonnee->setSupprimer(false);
                    //$typeDonnee->setAuteur($currentUser->getUserIdentifier());
                    $typeDonnee->setCreated(new \DateTimeImmutable());

                    $this->entityManager->persist($typeDonnee);
                    $this->entityManager->flush();


                    //Mouchard
                    $this->saveMouchard("typeDonnee", $typeDonnee->getId(), $typeDonnee->getLibelle(),
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', 'Enregistrement du type donné '. $typeDonnee->getLibelle() .' effectué avec succès.');
                    return $this->redirectToRoute('app_typeDonnee_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('typeDonnee/new.html.twig', [
                    'typeDonnee' => $typeDonnee,
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
