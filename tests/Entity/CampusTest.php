<?php

namespace App\Tests\Entity;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Sortie;
use PHPUnit\Framework\TestCase;

class CampusTest extends TestCase
{
    public function testSomething(): void
    {

        $campus = new Campus();
        $sorty = new Sortie();
        $user = new Participant();

        $campus->setNom('nom');
        $campus->addParticipant($user);
        $campus->addSorty($sorty);

        $this->assertEquals('nom', $campus->getNom());
        $this->assertNotNull($campus->getSorties());
        $this->assertNotNull($campus->getParticipants());
        $this->assertNull($campus->getId());

        $campus->removeParticipant($user);
        $campus->removeSorty($sorty);
    }
}
