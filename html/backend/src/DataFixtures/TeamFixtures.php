<?php

namespace App\DataFixtures;

use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TeamFixtures extends Fixture
{
    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('team1@gmail.com');
        $user1->setPassword($this->userPasswordHasher->hashPassword($user1, "azerty"));
        $user1->setRoles(['ROLE_TEAM']);
        $manager->persist($user1);

        $team1 = new Team();
        $team1->setUser($user1);
        $team1->setName('Team 1');
        $team1->setLogo('team1.png');
        $team1->setTag('T1');
        $manager->persist($team1);

        $user2 = new User();
        $user2->setEmail('team2@gmail.com');
        $user2->setPassword($this->userPasswordHasher->hashPassword($user2, "azerty"));
        $user2->setRoles(['ROLE_TEAM']);
        $manager->persist($user2);

        $team2 = new Team();
        $team2->setUser($user2);
        $team2->setName('Team 2');
        $team2->setLogo('team2.png');
        $team2->setTag('T2');
        $manager->persist($team2);

        $manager->flush();
    }
}
