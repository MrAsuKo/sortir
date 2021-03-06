<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Form\FilterCampusType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampusController extends AbstractController
{
    #[Route('/campus/admin',
            name: 'campus_liste')]
    public function afficherCampus(
        CampusRepository        $campusRepository,
        Request                 $request,
        EntityManagerInterface  $em
    ): Response
    {

        $campus = new Campus();
        $newCampus = new Campus();

        $campusForm = $this->createForm(CampusType::class,$newCampus);
        $campusForm->handleRequest($request);

        $filterForm = $this->createForm(FilterCampusType::class, $campus);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted() && $filterForm->isValid())
        {
            $nom = $campus->getNom();
            $listCampus = $campusRepository->findCampus($nom);
        }
        else
        {
            $listCampus = $campusRepository->findAll();
        }

        if ($campusForm->isSubmitted() && $campusForm->isValid())
        {
            $em->persist($newCampus);
            $em->flush();
            $this->addFlash(
                'bravo',
                'Le campus a bien été ajouté'
            );

            return $this->redirectToRoute('campus_liste');

        }

        return $this->render('campus/index.html.twig',
            [   'campusForm' => $campusForm->createView(),
                'filterForm' => $filterForm->createView(),
                "listCampus" => $listCampus
            ]
        );
    }

    #[Route('/campus/admin/supprimer/{id}',
            name: 'campus_supprimer')]
    public function supprimer(
        EntityManagerInterface $em,
        Campus                 $campus
    ): Response
    {

        $em->remove($campus) ;
        $em->flush();

        $this->addFlash(
            'bravo',
            'Le campus a bien été supprimé'
        );

        return $this->redirectToRoute('campus_liste');
    }

    #[Route('/campus/admin/modifier/{id}',
        name: 'campus_modifier')]
    public function modifier(
        EntityManagerInterface $em,
        Campus                 $campus,
        Request $request
    ): Response
    {

        $campusForm = $this->createForm(CampusType::class,$campus);
        $campusForm->handleRequest($request);

        if ($campusForm->isSubmitted() && $campusForm->isValid())
        {
            $em->persist($campus);
            $em->flush();
            $this->addFlash(
                'bravo',
                'Le campus a bien été modifié'
            );

            return $this->redirectToRoute('campus_liste');
        }

        return $this->render('campus/modifier.html.twig',
            [
                'campusForm' => $campusForm->createView(),
            ]
        );

    }



}
