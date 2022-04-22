<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationFormType;
use App\Repository\AvatarRepository;
use App\Service\Courriel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register/admin',
        name: 'register')]
    public function register(
        Request                     $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface      $entityManager,
        Courriel                    $courriel,
        AvatarRepository            $ar,
    ): Response
    {
        $user = new Participant();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        $mdp = $this->passRandom();

        if ($form->isSubmitted() && $form->isValid())
        {
            //$avatar = $ar->findOneBy(['id' => 1]);

            $user -> setAdministrateur(false);
            $user -> setActif(true);
            //   $user->setAvatar($avatar);
            $user -> setCampus($form->get('campus')->getData());

            $plainPassword = $mdp;
            // encode the plain password

            $user->setPassword
            (
                $userPasswordHasher->hashPassword
                (
                    $user,
                    $plainPassword
                )
            );
            $mail = $user->getMail();
            $entityManager->persist($user);
            $entityManager->flush();

            $corps='Bonjour, avec votre email, et le password '.$mdp .', vous pouvez vous connecter au site de sortie';
            $courriel->envoi($mail,'Espace Utilisateur',$corps,'admin@sortir.fr');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig',
            [
            'registrationForm' => $form->createView(),
            ]
        );
    }

    function passRandom():string
    {
        $nbChar=6;
        $chaine ="mnoTUzS5678kVvwxy9WXYZRNCDEFrslq41GtuaHIJKpOPQA23LcdefghiBMbj0";
        $pass = '' ;

        srand((double)microtime()*1000000);

        for($i=0; $i<$nbChar; $i++)
        {
            $pass .= $chaine[rand()%strlen($chaine)];
        }

        return $pass;
    }
}
