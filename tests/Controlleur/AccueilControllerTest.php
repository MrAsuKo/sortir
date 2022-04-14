<?php

namespace App\Tests\Controlleur;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccueilControllerTest extends WebTestCase
{
    public function testAccueilController(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/accueil');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.index_td_head1', 'Nom de la sortie');
    }
}
