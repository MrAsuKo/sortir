<?php

namespace App\Tests\Entity;

use App\Entity\Avatar;
use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;


class AvatarTest extends TestCase
{
    public function testSomething(): void
    {
        $date = new DateTime();
        $avatar = new Avatar('nom', $date);
        $file = new File('.env');

        $avatar->setAvatar('avatar');
        $avatar->setAvatarFile($file);

        $this->assertNull($avatar->getId());
        $this->assertNotNull($avatar->getAvatarFile());
        $this->assertEquals('avatar', $avatar->getAvatar());

        $this->assertTrue(true);
    }
}
