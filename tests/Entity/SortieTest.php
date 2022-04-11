<?php

namespace App\Tests\Entity;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use DateTime;
use PHPUnit\Framework\TestCase;

class SortieTest extends TestCase
{
    public function testSomething(): void
    {

        $sortie = new Sortie();
        $user = new Participant();
        $campus = new Campus();
        $lieu = new Lieu();
        $etat = new Etat();
        $date = new DateTime();

        $sortie->setNom('nom');
        $sortie->setCampus($campus);
        $sortie->setLieu($lieu);
        $sortie->setDateHeureDebut($date);
        $sortie->setDateLimiteInscription($date);
        $sortie->setDuree(120);
        $sortie->setEtat($etat);
        $sortie->setInfosSortie('infos');
        $sortie->setNbInscriptionsMax(10);
        $sortie->setOrganisateur($user);
        $sortie->addParticipant($user);

        $this->assertEquals('nom', $sortie->getNom());
        $this->assertEquals('infos', $sortie->getInfosSortie());
        $this->assertEquals(120, $sortie->getDuree());
        $this->assertEquals(10, $sortie->getNbInscriptionsMax());
        $this->assertEquals($date, $sortie->getDateHeureDebut());
        $this->assertEquals($date, $sortie->getDateLimiteInscription());

        $this->assertNotNull($sortie->getCampus());
        $this->assertNotNull($sortie->getEtat());
        $this->assertNotNull($sortie->getLieu());
        $this->assertNotNull($sortie->getOrganisateur());
        $this->assertNotNull($sortie->getParticipant());
        $this->assertNull($sortie->getId());

        $sortie->removeParticipant($user);

    }
}
