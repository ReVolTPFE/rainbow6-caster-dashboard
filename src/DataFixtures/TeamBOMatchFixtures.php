<?php

namespace App\DataFixtures;

use App\Entity\BOMatch;
use App\Entity\Team;
use App\Entity\TeamBOMatch;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TeamBOMatchFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            TeamFixtures::class,
            BOMatchFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $match1 = $manager->getRepository(BOMatch::class)->findOneBy([], ['id' => 'ASC']);
        $team1 = $manager->getRepository(Team::class)->findOneBy([], ['id' => 'ASC']);
        $team2 = $manager->getRepository(Team::class)->findOneBy([], ['id' => 'DESC']);

        $teamBOMatch1 = new TeamBOMatch();
        $teamBOMatch1->setBOMatch($match1);
        $teamBOMatch1->setTeam($team1);
        $manager->persist($teamBOMatch1);

        $teamBOMatch1 = new TeamBOMatch();
        $teamBOMatch1->setBOMatch($match1);
        $teamBOMatch1->setTeam($team2);
        $manager->persist($teamBOMatch1);

        $match2 = $manager->getRepository(BOMatch::class)->findOneBy([], ['id' => 'DESC']);

        $teamBOMatch2 = new TeamBOMatch();
        $teamBOMatch2->setBOMatch($match2);
        $teamBOMatch2->setTeam($team1);
        $manager->persist($teamBOMatch2);

        $teamBOMatch2 = new TeamBOMatch();
        $teamBOMatch2->setBOMatch($match2);
        $teamBOMatch2->setTeam($team2);
        $manager->persist($teamBOMatch2);

        $manager->flush();
    }
}
