<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\ParticipantRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/sortie/creer',
            name: 'sortie_creer')]
    public function creerSortie
    (
        EntityManagerInterface  $em,
        Request                 $request,
        ParticipantRepository   $pr,
        EtatRepository          $er
    ): Response
    {
        if(!$this->getUser())
        {
            return $this->redirectToRoute('app_login');
        }

        $sortie = new Sortie();

        $user = $pr->findOneBy(['mail' => $this->getUser()->getUserIdentifier()]);

        $sortieForm = $this -> createForm(SortieType::class, $sortie);
        $sortieForm -> handleRequest($request);

        if ($sortieForm -> isSubmitted() && $sortieForm -> isValid())
        {
            $sortie->setLieu($sortieForm->get('lieu')->getData()) ;
            $sortie->setOrganisateur($user);
            $sortie->setCampus($user->getCampus());

            $date = new DateTime();

            if( $sortie->getDateLimiteInscription() <= $date || $sortie->getDateHeureDebut() <= $date)
            {
                $this->addFlash
                (
                    'Erreur',
                    'Vous avez créee une sortie antérieur à la date d\'aujourd\'hui'
                );

                return $this->redirectToRoute('app_accueil');
            }

            if ($sortieForm->getClickedButton() && 'enregistrer' === $sortieForm->getClickedButton()->getName())
            {

                $etat = $er->findOneBy(['id' => 1]);
                $sortie->setEtat($etat);

                $this->addFlash
                (
                    'Bravo',
                    'La sortie a bien été créée'
                );
            }
            else
            {
                $etat = $er->findOneBy(['id' => 2]);
                $sortie->setEtat($etat);

                $this->addFlash
                (
                    'Bravo',
                    'La sortie a bien été publiée'
                );
            }

            $em->persist($sortie);
            $em->flush();

            return $this -> redirectToRoute('app_accueil');
        }

        return $this->render(
            'sortie/creer.html.twig',
            [
                'sortieForm' => $sortieForm -> createView(),
                'user'       => $user
            ]
        );
    }

    #[Route('/sortie/modifier/{id}',
            name: 'sortie_modifier',
            requirements: ["id" => "\d+"])]
    public function modifierSortie(
        EtatRepository          $er,
        Sortie                  $sortie,
        ParticipantRepository   $pr,
        EntityManagerInterface  $em,
        Request                 $request
    ): Response
    {
        if(!$this->getUser())
        {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser()->getUserIdentifier();
        $user = $pr->findOneBy(['mail'=> $user]);

        if( $sortie->getOrganisateur() != $user)
        {

            $this->addFlash
            (
                'Erreur',
                'Vous ne pouvez pas modifer une sortie qui n\'est pas là vôtre'
            );

            return $this->redirectToRoute('app_accueil');
        }

        if ($sortie->getOrganisateur() === $user || $user->getAdministrateur())
        {
            $sortieForm = $this -> createForm(SortieType::class, $sortie);
            $sortieForm -> handleRequest($request);

            if ($sortieForm -> isSubmitted() && $sortieForm -> isValid())
            {
                $sortie->setLieu($sortieForm->get('lieu')->getData()) ;
                $sortie->setOrganisateur($user);
                $sortie->setCampus($user->getCampus());

                if ($sortieForm->getClickedButton() && 'enregistrer' === $sortieForm->getClickedButton()->getName())
                {
                    $etat = $er->findOneBy(['id' => 1]);
                    $sortie->setEtat($etat);

                    $this->addFlash
                    (
                        'Bravo',
                        'La sortie a bien été créée'
                    );
                }
                elseif( $sortieForm->getClickedButton() && 'publier' === $sortieForm->getClickedButton()->getName() )
                {
                    $etat = $er->findOneBy(['id' => 2]);
                    $sortie->setEtat($etat);
                    $this->addFlash
                    (
                        'Bravo',
                        'La sortie a bien été publiée'
                    );
                }
                else
                {
                    $etat = $er->findOneBy(['id' => 6]);
                    $sortie->setEtat($etat) ;
                    $this->addFlash
                    (
                        'Bravo',
                        'La sortie a bien été annulée'
                    );
                }

                $em->persist($sortie);
                $em->flush();

                return $this -> redirectToRoute('app_accueil');
            }

            return $this->render('sortie/modifier.html.twig',
                [
                    'sortieForm' => $sortieForm -> createView(),
                    'user'       => $user
                ]
            );
        }

        return $this->render('accueil/index.html.twig');
    }


    #[Route('/sortie/afficher/{id}',
            name: 'sortie_afficher')]
    public function afficherSorties
    (
        Sortie $sortie
    ): Response
    {
        if( $this->getUser())
        {
            return $this->render('sortie/afficher.html.twig',
                compact('sortie'));
        }
        else{
            return $this->redirectToRoute('app_login');
        }

    }



    #[Route('/sortie/annuler',
            name: 'sortie_annuler')]
    public function annulerSortie(): Response
    {
        return $this->render('sortie/annuler.html.twig',
            [
                'controller_name' => 'SortieController',
            ]
        );
    }

    #[Route('/sortie/inscription/{id}',
            name: 'sortie_inscription',
            requirements: ["id" => "\d+"])]
    public function inscription(
        ParticipantRepository   $pm,
        Sortie                  $sortie,
        EntityManagerInterface  $em
    ): Response
    {
        $now = new DateTime();
        $user = $this->getUser()->getUserIdentifier();
        $user = $pm->findOneBy(['mail' => $user]);

        if( $sortie->getEtat()->getLibelle() == "Ouverte" || $sortie->getEtat()->getLibelle() == "Clôturée")
        {

            if( $sortie->getParticipant()->contains($user) )
            {
                $sortie->removeParticipant($user);
            }
            else
            {
                if( $sortie->getEtat()->getLibelle() == "Ouverte" && $sortie->getDateLimiteInscription() > $now
                    && $sortie->getNbInscriptionsMax() > count($sortie->getParticipant()))
                {
                    $sortie->addParticipant($user);
                }
            }



            $em->persist($sortie);
            $em->flush();

        }
        return $this->redirectToRoute('app_accueil');
    }

}
