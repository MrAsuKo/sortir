<?php

namespace App\Tests\Entity;

use App\Entity\Participant;
use App\Entity\ResetPasswordRequest;
use Couchbase\User;
use PHPUnit\Framework\TestCase;

class ResetPasswordRequestTest extends TestCase
{
    public function testSomething(): void
    {

        $user = new Participant();
        $date = new \DateTime();
        $reset = new ResetPasswordRequest($user, $date, 'oui', 'non');


        $this->assertNull($reset->getId());
        $this->assertNotNull($reset->getUser());
        $this->assertTrue(true);
    }
}
