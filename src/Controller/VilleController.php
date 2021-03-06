<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\FilterVilleType;
use App\Form\VilleType;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController
{
    #[Route('/ville/admin',
        name:'ville_liste')]
    public function listeVilles(
        VilleRepository        $villeRepository,
        Request                $request,
        EntityManagerInterface $em
    ): Response
    {

        $ville = new Ville();
        $villeForm = $this->createForm(VilleType::class, $ville);
        $villeForm->handleRequest($request);

        $filterForm = $this->createForm(FilterVilleType::class, $ville);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $nom = $ville->getNom();
            $villes = $villeRepository->findVille($nom);
        } else {
            $villes = $villeRepository->findAll();
        }

        if ($villeForm->isSubmitted() && $villeForm->isValid()) {
            $em->persist($ville);
            $em->flush();

            $this->addFlash
            (
                'bravo',
                'la ville a bien été ajouté'
            );
            return $this->redirectToRoute('ville_liste');

        }
        return $this->render('ville/index.html.twig',
            [
                'villeForm' => $villeForm->createView(),
                'filterForm' => $filterForm->createView(),
                "villes" => $villes
            ]
        );
    }

    #[Route('/ville/Supprimer/{id}', name:'ville_Supprimer')]
    public function supprimer(
        VilleRepository        $villeRepository,
        EntityManagerInterface $em,
        int                    $id
    ): Response
    {
        $ville = $villeRepository->findOneBy(['id' => $id]);

        $em->remove($ville);
        $em->flush();

        return $this->redirectToRoute('ville_liste');
    }

    #[Route('/ville/{id}',
        requirements: ["id" => "\d+"])]
    public function findLieu(
        Ville           $ville
    ): JsonResponse
    {

        $lieux = $ville->getLieux();
        $lieuxId = [];
        $lieuxNoms = [];

        $ville = [$ville->getCodePostal(), $ville->getLieux()];

        foreach ($lieux as $lieu) {
            $lieuxId[] = $lieu->getId();
            $lieuxNoms[] = [$lieu->getNom()];
        }

        return new JsonResponse(
            [
                'ville' => $ville,
                'lieuxId' => $lieuxId,
                'lieuxNoms' => $lieuxNoms
            ]
        );

    }

    #[Route('/ville/modifier/{id}', name:'ville_modifier')]
    public function modifier(
        Request                $request,
        EntityManagerInterface $em,
        Ville $ville
    ): Response
    {

        $villeForm = $this->createForm(VilleType::class, $ville);
        $villeForm->handleRequest($request);


        if ($villeForm->isSubmitted() && $villeForm->isValid()) {
            $em->persist($ville);
            $em->flush() ;

            $this->addFlash
            (
                'bravo',
                'la ville a bien été modifié'
            );
            return $this->redirectToRoute('ville_liste');

        }
        return $this->render('ville/modifier.html.twig',
            [
                'villeForm' => $villeForm->createView(),
            ]
        );

    }
}