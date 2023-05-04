<?php

namespace App\DataFixtures;

use App\Entity\BOMatch;
use App\Entity\Status;
use App\Entity\Gamemode;
use App\Entity\Caster;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BOMatchFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            TeamFixtures::class,
            StatusFixtures::class,
            GamemodeFixtures::class,
            CasterFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $status1 = $manager->getRepository(Status::class)->findOneBy([], ['id' => 'ASC']);
        $status2 = $manager->getRepository(Status::class)->findOneBy([], ['id' => 'DESC']);
        $gamemode = $manager->getRepository(Gamemode::class)->findOneBy([], ['id' => 'ASC']);
        $caster = $manager->getRepository(Caster::class)->findOneBy([], ['id' => 'ASC']);
        $team1 = $manager->getRepository(Team::class)->findOneBy([], ['id' => 'ASC']);

        $match1 = new BOMatch();
        $match1->setName('Match 1');
        $match1->setStatus($status1);
        $match1->setGamemode($gamemode);
        $match1->setDate(new \DateTime('now'));
        $match1->setBanMap(['Map 1', 'Map 2', 'Map 3']);
        $match1->setCaster($caster);
        $manager->persist($match1);

        $match2 = new BOMatch();
        $match2->setName('Match 2');
        $match2->setStatus($status2);
        $match2->setGamemode($gamemode);
        $match2->setDate(new \DateTime('now'));
        $match2->setBanMap(['Map 1', 'Map 2', 'Map 3']);
        $match2->setCaster($caster);
        $match2->setWinnerTeam($team1);
        $manager->persist($match2);

        $manager->flush();
    }
}
