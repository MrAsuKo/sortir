<?php

namespace App\Tests\Entity;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use PHPUnit\Framework\TestCase;

class LieuTest extends TestCase
{
    public function testSomething(): void
    {

        $lieu = new Lieu();
        $ville = new Ville();
        $sorty = new Sortie();

        $lieu->setNom('nom');
        $lieu->setLatitude(4546);
        $lieu->setLongitude(16315);
        $lieu->setRue('rue');
        $lieu->setVille($ville);
        $lieu->addSorty($sorty);

        $this->assertEquals('nom', $lieu->getNom());
        $this->assertEquals(4546, $lieu->getLatitude());
        $this->assertEquals(16315, $lieu->getLongitude());
        $this->assertEquals('rue', $lieu->getRue());
        $this->assertNotNull( $lieu->getVille());
        $this->assertNotNull( $lieu->getSorties());

        $lieu->removeSorty($sorty);

    }
}
