<?php

namespace App\Controller;

use App\Entity\Planifier;
use App\Form\PlanifierType;
use App\Repository\PlanifierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/planifier')]
class PlanifierController extends AbstractController
{
    #[Route('/', name: 'app_planifier_index', methods: ['GET'])]
    public function index(PlanifierRepository $planifierRepository): Response
    {
        return $this->render('planifier/index.html.twig', [
            'planifiers' => $planifierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_planifier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $planifier = new Planifier();
        $form = $this->createForm(PlanifierType::class, $planifier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($planifier);
            $entityManager->flush();

            return $this->redirectToRoute('app_planifier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('planifier/new.html.twig', [
            'planifier' => $planifier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planifier_show', methods: ['GET'])]
    public function show(Planifier $planifier): Response
    {
        return $this->render('planifier/show.html.twig', [
            'planifier' => $planifier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_planifier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Planifier $planifier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanifierType::class, $planifier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_planifier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('planifier/edit.html.twig', [
            'planifier' => $planifier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planifier_delete', methods: ['POST'])]
    public function delete(Request $request, Planifier $planifier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planifier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($planifier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_planifier_index', [], Response::HTTP_SEE_OTHER);
    }
}
