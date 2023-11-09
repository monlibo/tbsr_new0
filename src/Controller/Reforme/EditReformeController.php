<?php

namespace App\Controller\Reforme;

use App\Entity\Reforme;
use App\Form\ReformeType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reforme')]
class EditReformeController extends AbstractController
{
    private $fileUploader;


    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    #[Route('/{id}/edit', name: 'app_reforme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reforme $reforme, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReformeType::class, $reforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            ///// Libert Start //////
            $file = $request->files->get('file');
            $targetDirectory = $this->getParameter('uploads_directory');
            $fileName = $this->fileUploader->upload($file, $targetDirectory);
            $reforme->setUrl("/uploads/" . $fileName);
            $reforme->setUrlAbsolute($targetDirectory . '/' . $fileName);
            ////// Libert End /////

            $entityManager->flush();

            return $this->redirectToRoute('app_reforme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reforme/edit.html.twig', [
            'reforme' => $reforme,
            'form' => $form,
        ]);
    }
}
