<?php

namespace App\Tests\Entity;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Sortie;
use PHPUnit\Framework\TestCase;

class ParticipantTest extends TestCase
{
    public function testSomething(): void
    {

        $user = new Participant();
        $campus = new Campus();
        $sortie = new Sortie();

        $user->setActif(true);
        $user->setAdministrateur(true);
        $user->setNom('nom');
        $user->setPseudo('pseudo');
        $user->setPassword('pass');
        $user->setRoles([]);
        $user->setCampus($campus);
        $user->setMail('mail');
        $user->setOrgaSorties($sortie);
        $user->setPrenom('prenom');
        $user->setTelephone('tel');
        $user->addSorty($sortie);

        $this->assertNotNull($user->getSorties());
        $this->assertTrue($user->getActif());
        $this->assertTrue($user->getAdministrateur());
        $this->assertTrue((bool)$user->getRoles());
        $this->assertTrue((bool)$user->getCampus());
        $this->assertTrue($user->getSorties());

        $this->assertEquals('email', $user->getUserIdentifier());
        $this->assertEquals('email', $user->getMail());
        $this->assertNull($user->getId());
        $this->assertEquals('nom', $user->getNom());
        $this->assertEquals('prenom', $user->getPrenom());
        $this->assertEquals('tel', $user->getTelephone());
        $this->assertEquals('pass', $user->getPassword());
        $this->assertEquals('pseudo', $user->getPseudo());

        $user->removeSorty($sortie);

    }
}
