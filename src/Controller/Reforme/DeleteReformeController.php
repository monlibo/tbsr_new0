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
class DeleteReformeController extends AbstractController
{

    #[Route('/{id}', name: 'app_reforme_delete', methods: ['POST'])]
    public function delete(Request $request, Reforme $reforme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reforme->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reforme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reforme_index', [], Response::HTTP_SEE_OTHER);
    }
}
