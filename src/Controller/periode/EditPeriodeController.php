<?php

namespace App\Controller\periode;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Periode;
use App\Form\PeriodeType;
use App\Repository\PeriodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/periode')]
class EditPeriodeController extends AbstractController
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager
    )
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/{id}/edit', name: 'app_periode_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Periode $periode, PeriodeRepository $periodeRepository): Response
    {

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            $currentUser = $this->getUser();

            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(PeriodeType::class, $periode);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $datedebut = $periode->getDateDebut();
                    $datefin = $periode->getDateFin();
                    
                    $periodeintervalle = $datedebut->format('d-m-Y') ." au " . $datefin->format('d-m-Y');
                    $periodeExistant = $periodeRepository->findOneBy(array('dateDebut' => $datedebut , 'dateFin' => $datefin , 'supprimer' => false));
                    if ($periodeExistant != null) {
                        if ($periode->getId() != $periodeExistant->getId()) {
                            $this->addFlash('error', 'cette periode ' . $periodeExistant->getPeriode() . ' n existe pas.',
                            );
                            return $this->redirectToRoute('app_periode_edit', array('id' => $periode->getId()));
                        }

                    }

                    $this->entityManager->flush();

                    $this->saveMouchard("periode", $periode->getId(), $periodeintervalle,
                        "modification", "profiluser", "user", "");


                    $this->addFlash('success', "Enregistrement modifié avec succès ");
                    return $this->redirectToRoute('app_periode_index', ['id' => $periode->getId()], Response::HTTP_SEE_OTHER);
                }

                return $this->render('periode/edit.html.twig', [
                    'periode' => $periode,
                    'form' => $form,
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
