<?php

namespace App\Controller;

use App\Form\FilterSortieType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function afficherAccueil
    (
        SortieRepository      $sm,
        ParticipantRepository $pm,
        Request               $request,
    ): Response
    {
        $sorties = $sm->findAll();
        $user = $pm->findOneBy(['mail' => $this->getUser()->getUserIdentifier()]);

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
                $now = new \DateTime();

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
        };

        return $this->render('accueil/index.html.twig',
            [
                'formProfil'    => $filterForm->createView(),
                'user'          => $user,
                'sorties'       => $sorties
            ]
        );
    }
}
