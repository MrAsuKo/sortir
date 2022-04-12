<?php

namespace App\Controller;

use App\Form\FilterSortieType;
use App\Form\FilterType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
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
        };

        return $this->render('accueil/index.html.twig',
            ['formProfil' => $filterForm->createView(),
                'user' => $user, 'sorties' => $sorties]);
    }
}
