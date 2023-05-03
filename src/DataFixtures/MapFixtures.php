<?php

namespace App\DataFixtures;

use App\Entity\Map;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MapFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $map1 = new Map();
        $map1->setName('Bank');
        $map1->setSlug('bank');
        $manager->persist($map1);

        $map2 = new Map();
        $map2->setName('Border');
        $map2->setSlug('border');
        $manager->persist($map2);

        $map3 = new Map();
        $map3->setName('Chalet');
        $map3->setSlug('chalet');
        $manager->persist($map3);

        $map4 = new Map();
        $map4->setName('Club House');
        $map4->setSlug('club-house');
        $manager->persist($map4);

        $map5 = new Map();
        $map5->setName('Coastline');
        $map5->setSlug('coastline');
        $manager->persist($map5);

        $map6 = new Map();
        $map6->setName('Consulate');
        $map6->setSlug('consulate');
        $manager->persist($map6);

        $map7 = new Map();
        $map7->setName('Favela');
        $map7->setSlug('favela');
        $manager->persist($map7);

        $map8 = new Map();
        $map8->setName('Fortress');
        $map8->setSlug('fortress');
        $manager->persist($map8);

        $map9 = new Map();
        $map9->setName('Hereford Base');
        $map9->setSlug('hereford-base');
        $manager->persist($map9);

        $map10 = new Map();
        $map10->setName('House');
        $map10->setSlug('house');
        $manager->persist($map10);

        $map11 = new Map();
        $map11->setName('Kafe Dostoyevsky');
        $map11->setSlug('kafe-dostoyevsky');
        $manager->persist($map11);

        $map12 = new Map();
        $map12->setName('Kanal');
        $map12->setSlug('kanal');
        $manager->persist($map12);

        $map13 = new Map();
        $map13->setName('Oregon');
        $map13->setSlug('oregon');
        $manager->persist($map13);

        $map14 = new Map();
        $map14->setName('Outback');
        $map14->setSlug('outback');
        $manager->persist($map14);

        $map15 = new Map();
        $map15->setName('Presidential Plane');
        $map15->setSlug('presidential-plane');
        $manager->persist($map15);

        $map16 = new Map();
        $map16->setName('Skyscraper');
        $map16->setSlug('skyscraper');
        $manager->persist($map16);

        $map17 = new Map();
        $map17->setName('Theme Park');
        $map17->setSlug('theme-park');
        $manager->persist($map17);

        $map18 = new Map();
        $map18->setName('Tower');
        $map18->setSlug('tower');
        $manager->persist($map18);

        $map19 = new Map();
        $map19->setName('Villa');
        $map19->setSlug('villa');
        $manager->persist($map19);

        $map20 = new Map();
        $map20->setName('Nighthaven Labs');
        $map20->setSlug('nighthaven-labs');
        $manager->persist($map20);

        $map21 = new Map();
        $map21->setName('Stadium');
        $map21->setSlug('stadium');
        $manager->persist($map21);

        $map22 = new Map();
        $map22->setName('Emerald Plains');
        $map22->setSlug('emerald-plains');
        $manager->persist($map22);

        $map23 = new Map();
        $map23->setName('Yacht');
        $map23->setSlug('yacht');
        $manager->persist($map23);

        $manager->flush();
    }
}
