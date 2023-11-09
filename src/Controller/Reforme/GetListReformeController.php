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
class GetListReformeController extends AbstractController
{
    #[Route('/', name: 'app_reforme_index', methods: ['GET'])]
    public function index(ReformeRepository $reformeRepository): Response
    {
        return $this->render('reforme/index.html.twig', [
            'reformes' => $reformeRepository->findAll(),
        ]);
    }
}
