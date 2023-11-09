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
class DeleteTypeDonneeController extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}/delete', name: 'app_typeDonnee_delete', methods: ['POST'])]
    public function delete(Request $request, TypeDonnee $typeDonnee): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $typeDonnee->getId(), $request->request->get('_token'))) {

                    //Vérification liaison avec d'autres tables
                    $typeDonneeUtilise = $this->entityManager->getRepository(ActiviteTypeDonnee::class)->findOneBy(array('typeDonnee' =>$typeDonnee, 'supprimer' => false));
                    if ($typeDonneeUtilise != null) {
                        $this->addFlash('error', 'Ce type donné est relié à une activité. Impossible de procéder à la suppression');
                        return $this->redirectToRoute('app_typeDonnee_index');
                    }

                    $typeDonnee->setSupprimer(true);
                    $typeDonnee->setSupprimerAuteur("user");
                    $typeDonnee->setSupprimerDate(new \DateTimeImmutable());
                    $this->entityManager->flush();


                    $this->saveMouchard("TypeDonnee", $typeDonnee->getId(), $typeDonnee->getLibelle(),
                        "suppression", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement supprimé avec succès");

                    return $this->redirectToRoute('app_typeDonnee_index', [], Response::HTTP_SEE_OTHER);
                }
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
