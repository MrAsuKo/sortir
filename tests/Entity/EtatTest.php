<?php

namespace App\Tests\Entity;

use App\Entity\Etat;
use App\Entity\Sortie;
use PHPUnit\Framework\TestCase;

class EtatTest extends TestCase
{
    public function testSomething(): void
    {
        $etat = new Etat();
        $sortie = new Sortie();

        $etat->setLibelle('libelle');
        $etat->addSorty($sortie);

        $this->assertNull($etat->getId());
        $this->assertEquals('libelle', $etat->getLibelle());
        $this->assertNotNull($etat->getSorties());

        $etat->removeSorty($sortie);
    }
}
