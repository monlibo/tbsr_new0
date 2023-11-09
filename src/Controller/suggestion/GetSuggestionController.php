<?php

namespace App\Controller\suggestion;

use App\Entity\Suggestion;
use App\Form\SuggestionType;
use App\Repository\SuggestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/suggestion')]
class GetSuggestionController extends AbstractController
{
    #[Route('/{id}', name: 'app_suggestion_show', methods: ['GET'])]
    public function show(Suggestion $suggestion): Response
    {
        return $this->render('suggestion/show.html.twig', [
            'suggestion' => $suggestion,
        ]);
    }

}
