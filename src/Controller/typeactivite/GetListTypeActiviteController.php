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
class GetListTypeActiviteController extends AbstractController
{
    #[Route('/', name: 'app_type_activite_index', methods: ['GET'])]
    public function index(TypeActiviteRepository $typeActiviteRepository): Response
    {
        return $this->render('type_activite/index.html.twig', [
            'type_activites' => $typeActiviteRepository->findAll(),
        ]);
    }

}
