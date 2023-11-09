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
class GetTypeActiviteController extends AbstractController
{

    #[Route('/{id}', name: 'app_type_activite_show', methods: ['GET'])]
    public function show(TypeActivite $typeActivite): Response
    {
        return $this->render('type_activite/show.html.twig', [
            'type_activite' => $typeActivite,
        ]);
    }

}
