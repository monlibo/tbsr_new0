<?php

namespace App\Controller\niveauvisibilite;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\NiveauVisibilite;
use App\Form\NiveauVisibiliteType;
use App\Repository\NiveauVisibiliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/niveauvisibilite')]
class DeleteNiveauVisibiliteController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}', name: 'app_niveauvisibilite_delete', methods: ['POST'])]
    public function delete(Request $request, NiveauVisibilite $niveauVisibilite, EntityManagerInterface $entityManager, NiveauVisibiliteRepository $niveauVisibiliteRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $niveauVisibilite->getId(), $request->request->get('_token'))) {

                    /////Libert Start ==> Je l'ai mis en commentaire volontairement /////
                    //Vérification liaison avec d'autres tables
                    // $niveauVisibiliteUtilise = $this->entityManager->getRepository(NiveauVisibilite::class)->findOneBy(array('bailleur' => $niveauVisibilite, 'supprimer' => false));
                    // if ($niveauVisibiliteUtilise != null) {
                    //     $this->addFlash('error', 'Ce niveau de visibilité est relié à une activité. Impossible de procéder à la suppression');
                    //     return $this->redirectToRoute('app_niveauvisibilite_index');
                    // }
                    //// Libert End ////

                    $niveauVisibilite->setSupprimer(true);
                    $niveauVisibilite->setSupprimerAuteur("user");
                    $niveauVisibilite->setSupprimerDate(new \DateTimeImmutable());
                    $this->entityManager->flush();

                    $this->saveMouchard(
                        "Bailleur",
                        $niveauVisibilite->getId(),
                        $niveauVisibilite->getLibelle(),
                        "suppression",
                        "profiluser",
                        "user",
                        ""
                    );


                    $this->addFlash('success', "Niveau de visibilité supprimé avec succès");

                    return $this->redirectToRoute('app_niveauvisibilite_index', [], Response::HTTP_SEE_OTHER);
                }
                return $this->render('niveauvisibilite/index.html.twig', [
                    'niveau_visibilites' => $niveauVisibiliteRepository->findBy(['supprimer' => false]),
                ]);
            } else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        } else {
            return $this->redirectToRoute('tbsr_capr_default');
        }
    }

    public
    function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }
}
