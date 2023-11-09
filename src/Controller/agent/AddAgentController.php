<?php

namespace App\Controller\agent;

use App\Controller\ClassesPersonnalisees\ClasseUsuelle;
use App\Entity\Agent;
use App\Form\AgentType;
use App\Repository\AgentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/agent')]
class AddAgentController extends AbstractController
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private EntityManagerInterface $entityManager;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $entityManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }


    #[Route('/new', name: 'app_agent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, AgentRepository $agentRepository): Response
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentUser = $this->getUser();

            if (false === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $agent = new Agent();
                $form = $this->createForm(AgentType::class, $agent);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    //Ainsi de suite pour les autres autres champs à contrôler
                    $agentExistant = $agentRepository->findOneBy(array('matricule' => $agent->getMatricule(), 'supprimer' => false));
                    if ($agentExistant != null) {
                        $this->addFlash('error', 'Un agent ayant le même matricule ' . $agentExistant->getMatricule() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_agent_new', array('id' => $agent->getIdentifiantAgent()));
                    }

                    $agentExistant = $agentRepository->findOneBy(array('telephone' => $agent->getTelephone(), 'supprimer' => false));
                    if ($agentExistant != null) {
                        $this->addFlash('error', 'Un agent ayant le même téléphone ' . $agentExistant->getTelephone() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_agent_new', array('id' => $agent->getIdentifiantAgent()));
                    }

                    $agentExistant = $agentRepository->findOneBy(array('email' => $agent->getEmail(), 'supprimer' => false));
                    if ($agentExistant != null) {
                        $this->addFlash('error', 'Un agent ayant le même Email ' . $agentExistant->getEmail() . ' existe déjà.',
                        );
                        return $this->redirectToRoute('app_agent_new', array('id' => $agent->getIdentifiantAgent()));
                    }

                    //$agent->setLibelle()
                    $agent->setSupprimer(false);
                    //$agent->setAuteur($currentUser->getUserIdentifier());
                    $agent->setCreated(new \DateTimeImmutable());

                    $entityManager->persist($agent);
                    $entityManager->flush();


                    //Mouchard
                    $this->saveMouchard("agent", $agent->getIdentifiantAgent(),  $agent->getNom() . ' '. $agent->getPrenom() ,
                        "enregistrement", "profil", "user", "");

                    //Flashbag
                    $this->addFlash('success', 'Enregistrement de l\'agent '. $agent->getNom() . ' '. $agent->getPrenom() .' effectué avec succès.');

                    return $this->redirectToRoute('app_agent_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('agent/new.html.twig', [
                    'agent' => $agent,
                    'form' => $form,
                ]);
            }else {
                return $this->redirectToRoute('tbsr_capr_default');
            }
        }else {
            return $this->redirectToRoute('tbsr_capr_default');
            // throw new AccessDeniedException();
        }
    }


    public function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations)
    {
        ClasseUsuelle::saveMouchardCu($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations, $this->entityManager);
    }
}
