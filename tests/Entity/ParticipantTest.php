<?php

namespace App\Tests\Entity;

use App\Entity\Avatar;
use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Sortie;
use DateTime;
use PHPUnit\Framework\TestCase;

class ParticipantTest extends TestCase
{
    public function testParticipant(): void
    {

        $date = new DateTime();

        $user = new Participant();
        $campus = new Campus();
        $sortie = new Sortie();
        $avatar = new Avatar('nom', $date);

        $user->setActif(true);
        $user->setAdministrateur(true);
        $user->setNom('nom');
        $user->setPseudo('pseudo');
        $user->setPassword('pass');
        $user->setRoles([]);
        $user->setCampus($campus);
        $user->setMail('mail');
        $user->setOrgaSorties([$sortie]);
        $user->setPrenom('prenom');
        $user->setTelephone('tel');
        $user->addSorty($sortie);
        $user->setAvatar($avatar);

        $this->assertNotNull($user->getSorties());
        $this->assertTrue($user->getActif());
        $this->assertTrue($user->getAdministrateur());
        $this->assertTrue((bool)$user->getRoles());
        $this->assertTrue((bool)$user->getCampus());
        $this->assertNotNull($user->getSorties());
        $this->assertNotNull($user->getOrgaSorties());
        $this->assertNotNull($user->getAvatar());

        $this->assertEquals('mail', $user->getUserIdentifier());
        $this->assertEquals('mail', $user->getMail());
        $this->assertNull($user->getId());
        $this->assertEquals('nom', $user->getNom());
        $this->assertEquals('prenom', $user->getPrenom());
        $this->assertEquals('tel', $user->getTelephone());
        $this->assertEquals('pass', $user->getPassword());
        $this->assertEquals('pseudo', $user->getPseudo());

        $user->removeSorty($sortie);

        $user->__toString();

    }
}
