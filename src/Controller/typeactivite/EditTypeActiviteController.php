<?php

namespace App\Controller\typeactivite;

use App\Entity\TypeActivite;
use App\Form\TypeActiviteType;
use App\Repository\TypeActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/activite')]
class EditTypeActiviteController extends AbstractController
{

    #[Route('/{id}/edit', name: 'app_type_activite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeActivite $typeActivite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeActiviteType::class, $typeActivite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_activite_show', ['id'=>$typeActivite->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_activite/edit.html.twig', [
            'type_activite' => $typeActivite,
            'form' => $form,
        ]);
    }

}
