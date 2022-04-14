<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Entity\Participant;
use App\Form\AvatarType;
use App\Form\ProfilType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilController extends AbstractController
{
    #[Route('/profil/modif', name: 'profil_modif')]
    public function modif(
        EntityManagerInterface $em,
        Request                $request,
        ParticipantRepository  $participantRepository,
        UserPasswordHasherInterface $participantPasswordHasher,
        SluggerInterface $slugger
    ): Response
    {

        $participant = $participantRepository->findOneBy(['mail' => $this->getUser()->getUserIdentifier()]);
        $profilForm = $this->createForm(ProfilType::class,$participant);
        $profilForm->handleRequest($request);


        if ($profilForm->isSubmitted() && $profilForm->isValid()) {
                $em->persist($participant->getAvatar());
                $participant->setPassword(
                $participantPasswordHasher->hashPassword(
                $participant,
                $profilForm->get('password')->getData()
            ));
            //dd($participant);
            $em->persist($participant);
            $em->flush();


            return $this->redirectToRoute('app_accueil');
        }
        return $this->render('profil/modifProfil.html.twig',
            ['formProfil' =>$profilForm->createView(), 'participant'=> $participant]
        );
    }

    #[Route('/profil/affichage/{id}', name: 'profil_affichage')]
    public function affichage(
        Participant $profil
    ):Response
    {
        return $this->render('profil/affichage.html.twig',
        compact('profil')
        );
    }

}
