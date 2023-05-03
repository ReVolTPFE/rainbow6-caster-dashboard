<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $status1 = new Status();
        $status1->setName('Not Started');
        $status1->setColorCode('#FF0000');
        $manager->persist($status1);

        $status2 = new Status();
        $status2->setName('In Progress');
        $status2->setColorCode('#FFFF00');
        $manager->persist($status2);

        $status3 = new Status();
        $status3->setName('Finished');
        $status3->setColorCode('#00FF00');
        $manager->persist($status3);

        $manager->flush();
    }
}
