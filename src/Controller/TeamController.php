<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/teams')]
class TeamController extends AbstractController
{
    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    #[Route('', name: 'app_teams_get_teams', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function getTeams(TeamRepository $teamRepository, SerializerInterface $serializer): JsonResponse
    {
        $teams = $teamRepository->findAll();
        $jsonTeams = $serializer->serialize($teams, 'json', ['groups' => 'user:read']);

        return new JsonResponse($jsonTeams, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('', name: 'app_teams_create_team', methods: ['POST'])]
    public function createTeam(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $data['password']));
        $user->setRoles(['ROLE_TEAM']);

        $team = new Team();
        $team->setName($data['name']);
        $team->setLogo($data['logo']);
        $team->setTag($data['tag']);
        $team->setUser($user);

        $manager->persist($user);
        $manager->persist($team);

        $manager->flush();

        $jsonTeam = $serializer->serialize($team, 'json', ['groups' => 'user:read']);

        return new JsonResponse($jsonTeam, Response::HTTP_CREATED, ['accept' => 'json'], true);
    }

    #[Route('/{id}', name: 'app_teams_get_one_team', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function getOneTeam(Team $team, SerializerInterface $serializer): JsonResponse
    {
        $jsonTeam = $serializer->serialize($team, 'json', ['groups' => 'user:read']);

        return new JsonResponse($jsonTeam, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('/{id}', name: 'app_teams_update_team', methods: ['PUT'])]
    #[IsGranted('ROLE_TEAM', message: 'You don\'t have the right to access to this ressource.')]
    public function updateTeam(Team $team, Request $request, SerializerInterface $serializer, EntityManagerInterface $manager): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $user = $team->getUser();

        $team->setName($data['name']);
        $team->setLogo($data['logo']);
        $team->setTag($data['tag']);

        $manager->persist($user);
        $manager->persist($team);

        $manager->flush();

        $jsonTeam = $serializer->serialize($team, 'json', ['groups' => 'user:read']);

        return new JsonResponse($jsonTeam, Response::HTTP_OK, ['accept' => 'json'], true);
    }
}
