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
class DeleteTypeActiviteController extends AbstractController
{
    #[Route('/', name: 'app_type_activite_index', methods: ['GET'])]
    public function index(TypeActiviteRepository $typeActiviteRepository): Response
    {
        return $this->render('type_activite/index.html.twig', [
            'type_activites' => $typeActiviteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_activite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeActivite = new TypeActivite();
        $form = $this->createForm(TypeActiviteType::class, $typeActivite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeActivite);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_activite/new.html.twig', [
            'type_activite' => $typeActivite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_activite_show', methods: ['GET'])]
    public function show(TypeActivite $typeActivite): Response
    {
        return $this->render('type_activite/show.html.twig', [
            'type_activite' => $typeActivite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_activite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeActivite $typeActivite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeActiviteType::class, $typeActivite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_activite/edit.html.twig', [
            'type_activite' => $typeActivite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_activite_delete', methods: ['POST'])]
    public function delete(Request $request, TypeActivite $typeActivite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeActivite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeActivite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_activite_index', [], Response::HTTP_SEE_OTHER);
    }
}
