<?php

namespace App\Controller\Executer;

use App\Entity\Executer;
use App\Form\ExecuterType;
use App\Repository\ExecuterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/executer')]
class ExecuterController extends AbstractController
{
    #[Route('/', name: 'app_executer_index', methods: ['GET'])]
    public function index(ExecuterRepository $executerRepository): Response
    {
        return $this->render('executer/index.html.twig', [
            'executers' => $executerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_executer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $executer = new Executer();
        $form = $this->createForm(ExecuterType::class, $executer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($executer);
            $entityManager->flush();

            return $this->redirectToRoute('app_executer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('executer/new.html.twig', [
            'executer' => $executer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_executer_show', methods: ['GET'])]
    public function show(Executer $executer): Response
    {
        return $this->render('executer/show.html.twig', [
            'executer' => $executer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_executer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Executer $executer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExecuterType::class, $executer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_executer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('executer/edit.html.twig', [
            'executer' => $executer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_executer_delete', methods: ['POST'])]
    public function delete(Request $request, Executer $executer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$executer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($executer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_executer_index', [], Response::HTTP_SEE_OTHER);
    }
}
