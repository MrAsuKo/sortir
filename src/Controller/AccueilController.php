<?php

namespace App\Controller;

use App\Form\FilterSortieType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function afficherAccueil
    (
        EntityManagerInterface $em,
        SortieRepository      $sm,
        EtatRepository        $er,
        Request               $request,
    ): Response
    {
        $date = new DateTime();
        $sorties = $sm->findAll() ;

        foreach ( $sorties as $sortie)
        {

            $etat = $sortie->getEtat()->getId();

            if($etat == 2)
            {
                if( $date >$sortie->getDateLimiteInscription() || $sortie->getNbInscriptionsMax() <= count($sortie->getParticipant()))
                {
                    $sortie->setEtat( $er->findOneBy(['libelle' => 'Clôturée']));
                }

                if( $date >$sortie->getDateHeureDebut())
                {
                    $sortie->setEtat( $er->findOneBy(['libelle' => 'Passée']));
                }

            }

            if($etat == 3)
            {
                if( $date >$sortie->getDateHeureDebut())
                {
                    $sortie->setEtat( $er->findOneBy(['libelle' => 'Passée']));
                }

            }

            $em->persist($sortie);
            $em->flush();

        }


        $user = $this->getUser();

        $filterForm = $this->createForm(FilterSortieType::class);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted() && $filterForm->isValid())
        {

            $critere = $filterForm->getData();
            $sorties = $sm->Filter($critere);

            if($filterForm->get('organisateur')->getViewData())
            {
                $tabSorties = $sorties;
                $sorties = [];

               foreach( $tabSorties as $sortie )
               {
                   if( $sortie->getOrganisateur() == $user)
                   {
                       $sorties[] = $sortie;
                   }
               }
            }

            if($filterForm->get('dateLimiteInscription')->getViewData())
            {
                $tabSorties = $sorties;
                $sorties = [];
                $now = new DateTime();

                foreach( $tabSorties as $sortie )
                {
                    if( $sortie->getDateLimiteInscription() < $now)
                    {
                        $sorties[] = $sortie;
                    }
                }
            }

            $inscrit = $sorties;

            if($filterForm->get('participant')->getViewData())
            {
                $tabSorties = $sorties;
                $sorties = [];

                foreach( $tabSorties as $sortie )
                {
                    if( $sortie->getParticipant()->contains($user))
                    {
                        $sorties[] = $sortie;
                    }
                }
            }

            if($filterForm->get('inscrit')->getViewData())
            {
                $tabSorties = $inscrit;
                $sorties = [];

                foreach( $tabSorties as $sortie )
                {
                    if( !$sortie->getParticipant()->contains($user))
                    {
                        $sorties[] = $sortie;
                    }
                }
            }
        }

        return $this->render('accueil/index.html.twig',
            [
                'formFilter'    => $filterForm->createView(),
                'sorties'       => $sorties
            ]
        );
    }

}
