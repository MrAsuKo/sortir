<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    #[Route('/participants/admin',
            name: 'app_participants')]
    public function listeParticipants
    (
        ParticipantRepository $pr,
    ): Response
    {
        $users = $pr->findAll();

        return $this->render('admin/participants.html.twig',
            [
                'users' => $users,
            ]
        );
    }


    #[Route('/participant/supprimer/{id}',
            name: 'participant_supprimer',
            requirements: ["id" => "\d+"])]
    public function supprimerParticipant
    (
        ParticipantRepository   $pr,
        Participant             $user
    ): Response
    {

        $pr->supprimer($user);

        return $this->redirectToRoute('app_participants');
    }

    #[Route('/participant/inactif/{id}',
            name: 'participant_inactif',
            requirements: ["id" => "\d+"])]
    public function participantInactif
    (
        EntityManagerInterface  $em,
        Participant             $user
    ): Response
    {
        $user->setActif(0);

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_participants');
    }

    #[Route('/participant/actif/{id}',
            name: 'participant_actif',
            requirements: ["id" => "\d+"])]
    public function participantActif
    (
        EntityManagerInterface  $em,
        Participant             $user
    ): Response
    {
        $user->setActif(1);

        $em->persist($user) ;
        $em->flush();

        return $this->redirectToRoute('app_participants');
    }

}
