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
    #[Route('/campus', name: 'campus_liste')]
    public function index(
        CampusRepository $campusRepository,
        Request $request,
        EntityManagerInterface $em
    ): Response
    {

        $campus = new Campus();
        $campusForm = $this->createForm(CampusType::class,$campus);
        $campusForm->handleRequest($request);

        $filterForm = $this->createForm(FilterCampusType::class, $campus);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $nom = $campus->getNom();
            dump($nom);
            $campuss = $campusRepository->findCampus($nom);
            dump($campuss);
        } else {
            $campuss = $campusRepository->findAll();

        if ($campusForm->isSubmitted() && $campusForm->isValid()) {
            $em->persist($campus);
            $em->flush();
            $this->addFlash(
                'bravo',
                'la campus a bien été ajouté'
            );
            return $this->redirectToRoute('campus_liste');
        }
    }
        return $this->render('campus/index.html.twig',
            ['campusForm' => $campusForm->createView(),'filterForm' => $filterForm->createView(), "campuss" => $campuss ]
        );
    }

    #[Route('/campus/supprimer/{id}', name: 'campus_supprimer')]
    public function supprimer(
        CampusRepository       $campusRepository,
        EntityManagerInterface $em,
        int                    $id
    ): Response
    {
        $campus = $campusRepository->findOneById($id);

        $em->remove($campus);
        $em->flush();

        return $this->redirectToRoute('campus_liste');
    }



}
