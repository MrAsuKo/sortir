<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use App\Repository\LieuRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends AbstractController
{

    #[Route('/lieu/creer',
            name: 'lieu_creer')]
    public function creerLieu(
        Request                 $request,
        LieuRepository          $lr,
        EntityManagerInterface  $em,
        VilleRepository         $vr
    ): Response
    {
        $lieu = new Lieu();

        $lieuForm = $this->createForm(LieuType::class,$lieu);
        $lieuForm->handleRequest($request);

        if ($lieuForm->isSubmitted() && $lieuForm->isValid())
        {
            $em->persist($lieu->getVille());

            $em->persist($lieu);
            $em->flush();

            $this->addFlash(
                'bravo',
                'le lieu a bien été ajouté'
            );
            return $this->redirectToRoute('lieu_creer');
        }

        $lieux=$lr->findAll();
        $villes = $vr->findAll();

        return $this->render('lieu/index.html.twig',
            [
                'lieuForm' => $lieuForm->createView(),
                "lieux" => $lieux,
                "villes" => $villes
            ]
        );

    }

    #[Route('/lieu/{id}',
        requirements: ["id" => "\d+"])]
    public function findLieu
    (
        SortieRepository $sm,
        Lieu $lieu
    ): JsonResponse
    {

        $lieu = [$lieu->getRue(), $lieu->getLongitude(), $lieu->getLatitude()];
        return new JsonResponse(['lieu' => $lieu]);

    }
}
