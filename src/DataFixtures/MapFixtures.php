<?php

namespace App\DataFixtures;

use App\Entity\Map;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MapFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 9; $i++) { 
            $map = new Map();
            $map->setName('Map ' . $i);
            $map->setSlug('map-' . $i);
            $manager->persist($map);
        }

        $manager->flush();
    }
}
