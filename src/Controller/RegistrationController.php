<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationFormType;
use App\Service\Courriel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request,
                             UserPasswordHasherInterface $userPasswordHasher,
                             EntityManagerInterface $entityManager,
                             Courriel $courriel,
    ): Response
    {
        $user = new Participant();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user -> setAdministrateur(false);
            $user -> setActif(true);
            $user -> setCampus($form->get('campus')->getData());
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $mail= $user->getMail();
            $mdp = $user->getPassword();
            $entityManager->persist($user);
            $entityManager->flush();

            $corps='Bonjour, avec votre email, et le password '.$mdp;
            $courriel->envoi($mail,'Espace Utilisateur',$corps,'admin@sortir.fr');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
