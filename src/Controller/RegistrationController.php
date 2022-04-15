<?php

namespace App\Controller;

use App\Entity\Avatar;
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
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request,
                             UserPasswordHasherInterface $userPasswordHasher,
                             EntityManagerInterface $entityManager,
                             Courriel $courriel,
                            AvatarRepository $ar,
    ): Response
    {
        $user = new Participant();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $mdp = $this->passgen1();

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user -> setAdministrateur(false);
            $user -> setActif(true);
            $avatar = $ar->findOneById('1');
            $user->setAvatar($avatar);
            $user -> setCampus($form->get('campus')->getData());
            $plainPassword = $mdp;
            $user->setPassword(
            $userPasswordHasher->hashPassword(
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

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    function passgen1() {
        $nbChar=6;
        $chaine ="mnoTUzS5678kVvwxy9WXYZRNCDEFrslq41GtuaHIJKpOPQA23LcdefghiBMbj0";
        srand((double)microtime()*1000000);
        $pass = '';
        for($i=0; $i<$nbChar; $i++){
            $pass .= $chaine[rand()%strlen($chaine)];
        }
        return $pass;
    }
}
