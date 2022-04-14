<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends AbstractController
{

    #[Route('/lieu/{id}',
        requirements: ["id" => "\d+"])]
    public function findLieu(
        SortieRepository $sm,
        Lieu $lieu
    ): JsonResponse
    {
        $lieu = [$lieu->getRue(), $lieu->getLongitude(), $lieu->getLatitude()];
        return new JsonResponse(['lieu' => $lieu]);

    }
}
