<?php

namespace App\Controller\Reforme;

use App\Controller\ClassesPersonnalisees\AbstractControllerPersonnalisee;
use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Reforme;
use App\Form\ReformeType;
use App\Repository\ReformeRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/reforme')]
class AddReformeController extends AbstractControllerPersonnalisee
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    //Libert
    private $fileUploader;

    public function __construct(FileUploader $fileUploader, AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;

        // Libert
        $this->fileUploader = $fileUploader;
    }


    #[Route('/new', name: 'app_reforme_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ReformeRepository $reformeRepository): Response
    {
        //$request->get("file");

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $reforme = new Reforme();
                $form = $this->createForm(ReformeType::class, $reforme);
                $form->handleRequest($request);


                if ($form->isSubmitted() && $form->isValid()) {
                    //Ainsi de suite pour les autres autres champs à contrôler
                    $reformeExistant = $reformeRepository->findOneBy(array('libelle' => $reforme->getLibelle(), 'supprimer' => false));
                    if ($reformeExistant != null) {
                        $this->addFlash(
                            'error',
                            'Une reforme ayant le même libellé ' . $reformeExistant->getLibelle() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_reforme_new', array('id' => $reforme->getId()));
                    }

                    //$reforme->setLibelle()
                    $reforme->setSupprimer(false);
                    //$reforme->setAuteur($currentUser->getUserIdentifier());
                    $reforme->setCreated(new \DateTimeImmutable());

                    ///// Libert Start //////
                    $file = $request->files->get('file');
                    // if ($file == null) {
                    //     $this->addFlash(
                    //         'error',
                    //         'Vous devez spécifier une image',
                    //     );
                    //     return $this->redirectToRoute('app_reforme_new');
                    // }
                    $targetDirectory = $this->getParameter('uploads_directory');
                    $fileName = $this->fileUploader->upload($file, $targetDirectory);
                    $reforme->setUrl("/uploads/" . $fileName);
                    $reforme->setUrlAbsolute($targetDirectory . '/' . $fileName);
                    ////// Libert End /////


                    $entityManager->persist($reforme);
                    $entityManager->flush();

                    //Mouchard
                    $this->saveMouchard(
                        "reforme",
                        $reforme->getId(),
                        $reforme->getLibelle(),
                        "enregistrement",
                        "profil",
                        "user",
                        ""
                    );

                    //Flashbag
                    $this->addFlash('success', "Enregistrement d'une reforme " . $reforme->getLibelle() . ' effectué avec succès.');

                    return $this->redirectToRoute('app_reforme_index', [], Response::HTTP_SEE_OTHER);
                }
                return $this->render('reforme/new.html.twig', [
                    'reforme' => $reforme,
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


    private function saveFile(UploadedFile $file): string
    {
        // Get the original file name
        $originalFileName = $file->getClientOriginalName();

        // Generate a unique file name
        $fileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '-' . uniqid() . '.' . $file->guessExtension();

        // Move the uploaded file to a specific directory
        $targetDirectory = $this->getParameter('uploads_directory');
        $file->move($targetDirectory, $fileName);

        return $fileName;
    }
}
