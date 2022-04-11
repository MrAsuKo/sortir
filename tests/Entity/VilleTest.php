<?php

namespace App\Tests\Entity;

use App\Entity\Lieu;
use App\Entity\Ville;
use PHPUnit\Framework\TestCase;

class VilleTest extends TestCase
{
    public function testSomething(): void
    {
        $ville = new Ville();
        $lieu = new Lieu();

        $ville->setNom('nom');
        $ville->setCodePostal('cp');
        $ville->addLieux($lieu);

        $this->assertEquals('nom', $ville->getNom());
        $this->assertEquals('cp', $ville->getCodePostal());
        $this->assertNotNull($ville->getLieux());
        $this->assertNull($ville->getId());

        $ville->removeLieux($lieu);
    }
}
