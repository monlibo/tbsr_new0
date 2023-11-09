<?php

namespace App\Controller\periode;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Periode;
use App\Form\PeriodeType;
use App\Repository\PeriodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/periode')]
class AddPeriodeController   extends AbstractControllerPersonnalisee
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'app_periode_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PeriodeRepository $periodeRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();
            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $periode = new Periode();
                $form = $this->createForm(PeriodeType::class, $periode);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $datedebut = $periode->getDateDebut();
                    $datefin = $periode->getDateFin();
                    if ($datedebut < $datefin) {
                        $periodeintervalle = $datedebut->format('d-m-Y') ." au " . $datefin->format('d-m-Y');
                        $periodeExistant = $periodeRepository->findOneBy(array('dateDebut' => $datedebut , 'dateFin' => $datefin , 'supprimer' => false));
                        if ($periodeExistant != null) {
                            $this->addFlash('error', 'Cette periode du ' . $periodeintervalle . ' existe déjà.',
                            );
                            return $this->redirectToRoute('app_periode_new', array('id' => $periode->getId()));
                        }
                        //$periode->setLibelle()
                        $periode->setSupprimer(false);
                        //$periode->setAuteur($currentUser->getUserIdentifier());
                        $periode->setCreated(new \DateTimeImmutable());
                        $this->entityManager->persist($periode);
                        $this->entityManager->flush();
                        //Mouchard
                        $this->saveMouchard("periode", $periode->getId(), $periodeintervalle,
                            "enregistrement", "profil", "user", "");
                        //Flashbag
                        $this->addFlash('success', 'Enregistrement du periode '. $periodeintervalle .' effectué avec succès.');
                        return $this->redirectToRoute('app_periode_index', [], Response::HTTP_SEE_OTHER);
                    }
                    else{
                        $this->addFlash('error', 'La periode du debut ne doit pas etre superieur à la periode de fin.',
                            );
                            return $this->redirectToRoute('app_periode_new', array('id' => $periode->getId()));
                    }
                }

                return $this->render('periode/new.html.twig', [
                    'periode' => $periode,
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
