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
    public function index(
        SortieRepository      $sm,
        ParticipantRepository $pm,
        Request               $request,
    ): Response
    {
        $sorties = $sm->findAll();
        $user = $pm->findOneBy(['mail' => $this->getUser()->getUserIdentifier()]);
        $filterForm = $this->createForm(FilterSortieType::class);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {

            $critere = $filterForm->getData();
            $sorties = $sm->Filter($critere);


            if($filterForm->get('organisateur'))
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

            if($filterForm->get('dateLimiteInscription'))
            {
                $tabSorties = $sorties;
                $sorties = [];

                foreach( $tabSorties as $sortie )
                {
                    if( $sortie->getDateLimiteInscription() < getdate())
                    {
                        $sorties[] = $sortie;
                    }
                }
            }

            if($filterForm->get('participant'))
            {
                $tabSorties = $sorties;
                $sorties = [];

                foreach( $tabSorties as $sortie )
                {
                    if( $sortie->getParcipant)
                    {
                        $sorties[] = $sortie;
                    }
                }
            }

            if($filterForm->get('inscrit'))
            {
                $tabSorties = $sorties;
                $sorties = [];

                foreach( $tabSorties as $sortie )
                {
                    if( $sortie->getParticipant)
                    {
                        $sorties[] = $sortie;
                    }
                }
            }
        };

        return $this->render('accueil/index.html.twig',
            ['formProfil' => $filterForm->createView(),
                'user' => $user, 'sorties' => $sorties]);
    }
}
