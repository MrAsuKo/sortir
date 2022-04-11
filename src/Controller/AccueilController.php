<?php

namespace App\Controller;

use App\Form\FilterType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(
        SortieRepository $sm,
        ParticipantRepository $pm,
        Request $request
    ): Response
    {
        $sorties = $sm->findAll();
        $user = $pm->findOneBy(['mail' => $this->getUser()->getUserIdentifier()]);
        $filterForm = $this->createForm(FilterType::class);
        $filterForm->handleRequest($request);

        return $this->render('accueil/index.html.twig',
            ['formProfil' =>$filterForm->createView(),
            'user'=>$user, 'sorties' => $sorties]);
    }
}
