<?php

namespace App\Controller\Reforme;

use App\Entity\Reforme;
use App\Form\ReformeType;
use App\Repository\ReformeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reforme')]
class GetReformeController extends AbstractController
{
    #[Route('/{id}', name: 'app_reforme_show', methods: ['GET'])]
    public function show(Reforme $reforme): Response
    {
        return $this->render('reforme/show.html.twig', [
            'reforme' => $reforme,
        ]);
    }

}
