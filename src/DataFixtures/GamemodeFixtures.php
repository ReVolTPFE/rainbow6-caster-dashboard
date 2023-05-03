<?php

namespace App\DataFixtures;

use App\Entity\Gamemode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GamemodeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $gamemode1 = new Gamemode();
        $gamemode1->setName('Bomb');
        $manager->persist($gamemode1);

        $gamemode2 = new Gamemode();
        $gamemode2->setName('Secure Area');
        $manager->persist($gamemode2);

        $gamemode3 = new Gamemode();
        $gamemode3->setName('Hostage');
        $manager->persist($gamemode3);

        $manager->flush();
    }
}
