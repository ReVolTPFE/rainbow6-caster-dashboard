<?php

namespace App\DataFixtures;

use App\Entity\Caster;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CasterFixtures extends Fixture
{
    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('caster1@gmail.com');
        $user1->setPassword($this->userPasswordHasher->hashPassword($user1, "azerty"));
        $user1->setRoles(['ROLE_CASTER']);
        $manager->persist($user1);

        $caster1 = new Caster();
        $caster1->setUser($user1);
        $caster1->setNickname('caster1');
        $caster1->setFirstName('cast');
        $caster1->setLastName('er1');
        $manager->persist($caster1);

        $user2 = new User();
        $user2->setEmail('caster2@gmail.com');
        $user2->setPassword($this->userPasswordHasher->hashPassword($user2, "azerty"));
        $user2->setRoles(['ROLE_CASTER']);
        $manager->persist($user2);

        $caster2 = new Caster();
        $caster2->setUser($user2);
        $caster2->setNickname('caster2');
        $caster2->setFirstName('cast');
        $caster2->setLastName('er2');
        $manager->persist($caster2);

        $manager->flush();
    }
}
