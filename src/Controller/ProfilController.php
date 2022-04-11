<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ProfilType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil/modif', name: 'profil_modif')]
    public function modif(
        EntityManagerInterface $em,
        Request $request,
        ParticipantRepository $participantRepository
    ): Response
    {
        $participant = new Participant();
        $profilForm = $this->createForm(ProfilType::class,$participant);
        $profilForm->handleRequest($request);

        if ($profilForm->isSubmitted() && $profilForm->isValid()) {
            $em->persist($participant);
            $em->flush();
            return $this->redirectToRoute('/profil/modif');
        }

        return $this->render('profil/modifProfil.html.twig',
            ['formProfil' =>$profilForm->createView()]
        );
    }
}
