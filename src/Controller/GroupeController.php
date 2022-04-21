<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Entity\Participant;
use App\Form\GroupeType;
use App\Form\MembreType;
use App\Repository\GroupeRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupeController extends AbstractController
{
    #[Route('/groupe/creer', name: 'creer_groupe')]
    public function creerGroupe(
        Request $request,
        EntityManagerInterface $em,
        ParticipantRepository $pr
    ): Response
    {
        $groupe = new Groupe();
        $groupeForm = $this -> createForm(GroupeType::class, $groupe);
        $groupeForm -> handleRequest($request);

        if ($groupeForm -> isSubmitted() && $groupeForm -> isValid())
        {
            $user = $pr->findOneBy(['mail' => $this->getUser()->getUserIdentifier()]);
            $groupe->addMembre($user);

            $membres = $groupeForm->get('membres')->getData();

            foreach ( $membres as $membre)
            {
                $groupe->addMembre($membre);
            }

            $em->persist($groupe);
            $em->flush();

            return $this -> redirectToRoute('liste_groupe');
        }



        return $this->render('groupe/creer.html.twig',
        ['groupeForm' => $groupeForm -> createView()]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws \Doctrine\ORM\ORMException
     */
    #[Route('/groupe/supprimer/{id}',
        name: 'supprimer_groupe',
        requirements: ["id" => "\d+"])]
    public function supprimerGroupe(
        GroupeRepository $gp,
        Groupe $groupe
    ): Response
    {
        $gp->remove($groupe);

        return $this->redirectToRoute("liste_groupe");
    }

    #[Route('/groupe', name: 'liste_groupe')]
    public function groupe(
        GroupeRepository $gr
    ): Response
    {

        $groupes = $gr->findAll();


        return $this->render('groupe/index.html.twig', [
            'groupes' => $groupes,
        ]);

    }

    #[Route('/membre/supprimer/{id}{groupe}',
        name: 'supprimer_membre',
        requirements: ["id" => "\d+", "groupe" => "\d+"])]
    public function supprimerMembre(
        EntityManagerInterface $em,
        Groupe $groupe,
        Participant $participant
    ): Response
    {

        $groupe->removeMembre($participant);

        $em->persist($groupe);
        $em->flush();

        return $this->redirectToRoute("liste_groupe");

    }

    #[Route('/membre/ajouter/{groupe}',
        name: 'ajouter_membre',
        requirements: ["id" => "\d+", "groupe" => "\d+"])]
    public function ajouterMembre(
        EntityManagerInterface $em,
        Request $request,
        Groupe $groupe
    ): Response
    {

        $formAjoutMembre = $this->createForm(MembreType::class);
        $formAjoutMembre -> handleRequest($request);

        if ($formAjoutMembre -> isSubmitted() && $formAjoutMembre -> isValid())
        {
            $membres = $formAjoutMembre->get('membre')->getData();

           foreach ( $membres as $membre)
               {
                   $groupe->addMembre($membre);
               }

           $em->persist($groupe);
            $em->flush();
        }


        return $this->render('groupe/ajouterMembre.html.twig',
        [
            'formAjoutMembre' => $formAjoutMembre->createView(),
            'groupe' => $groupe->getMembres()
        ]);

    }
}
