<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login/direction',
        name: 'loginDirection')]
    public function direction(
        ParticipantRepository $pr
    ): Response
    {
        if ($this->getUser())
        {
            $user = $pr->findOneBy(["mail" => $this->getUser()->getUserIdentifier()]);

            $pseudo = $user->getPseudo() ;

            if ($pseudo != null)
            {
                return $this->redirectToRoute('app_accueil');
            }
            else
            {
                return $this->redirectToRoute('profil_modif');
            }
        }

        return $this->redirectToRoute('app_login');
    }
}