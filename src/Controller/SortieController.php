<?php

namespace App\Controller;


use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Form\SortieType;

use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/sortie/creer', name: 'sortie_creer')]
    public function creer(
        EntityManagerInterface $em,
        Request $request,
        ParticipantRepository $pr
    ): Response
    {
        $sortie = new Sortie();
        $user = $this->getUser()->getUserIdentifier();
        $user = $pr->findOneBy(['mail' => $user] );
        $sortieForm = $this -> createForm(SortieType::class, $sortie);
        $sortieForm -> handleRequest($request);
        if ($sortieForm -> isSubmitted() && $sortieForm -> isValid()) {
            $sortie->setLieu($sortieForm->get('lieu')->getData()) ;
            $em->persist($sortie);
            $em->flush();
            $this->addFlash(
                'Bravo',
                'La sortie a bien été créée'
            );
            return $this -> redirectToRoute('app_accueil');
        }
        return $this->render(
            'sortie/creer.html.twig',
            ['sortieForm' => $sortieForm -> createView(), 'user' => $user]
        );
    }

    #[Route('/sortie/modifier', name: 'sortie_modifier')]
    public function modifier(): Response
    {
        return $this->render('sortie/modifier.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

    #[Route('/sortie/afficher', name: 'sortie_afficher')]
    public function afficher(): Response
    {
        return $this->render('sortie/afficher.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

    #[Route('/sortie/annuler', name: 'sortie_annuler')]
    public function annuler(): Response
    {
        return $this->render('sortie/annuler.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

    #[Route('/sortie/lieu/{id}',
        requirements: ["id" => "\d+"])]
    public function findLieu(
        SortieRepository $sm,
        Lieu $lieu
    ): Response
    {

        return $this->json($lieu);

    }

    #[Route('/sortie/inscription/{id}', name: 'sortie_inscription', requirements: ["id" => "\d+"])]
    public function inscription(
        SortieRepository $sm,
        ParticipantRepository $pm,
        Sortie $sortie,
        EntityManagerInterface $em
    ): Response
    {
        $user = $this->getUser()->getUserIdentifier();
        $user = $pm->findOneBy(['mail' => $user]);

        if( $sortie->getParticipant()->contains($user) )
        {
            $sortie->removeParticipant($user);
        }
        else
        {
            $sortie->addParticipant($user);
        }


        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('app_accueil');
    }

}
