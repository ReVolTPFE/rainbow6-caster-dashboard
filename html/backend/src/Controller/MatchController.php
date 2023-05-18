<?php

namespace App\Controller;

use App\Entity\BOMatch;
use App\Entity\TeamBOMatch;
use App\Repository\BOMatchRepository;
use App\Repository\CasterRepository;
use App\Repository\GamemodeRepository;
use App\Repository\StatusRepository;
use App\Repository\TeamBOMatchRepository;
use App\Repository\TeamRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/matches')]
class MatchController extends AbstractController
{
    #[Route('', name: 'app_matches_get_matches', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function getMatches(BOMatchRepository $matchRepository, SerializerInterface $serializer): JsonResponse
    {
        $matches = $matchRepository->findAll();
        $jsonBOMatches = $serializer->serialize($matches, 'json', ['groups' => 'match:read']);

        return new JsonResponse($jsonBOMatches, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('', name: 'app_matches_create_match', methods: ['POST'])]
    #[IsGranted('ROLE_CASTER', message: 'You don\'t have the right to access to this ressource.')]
    public function createMatch(
        Request $request,
        SerializerInterface $serializer,
        BOMatchRepository $matchRepository,
        StatusRepository $statusRepository,
        GamemodeRepository $gamemodeRepository,
        CasterRepository $casterRepository,
        TeamRepository $teamRepository,
        TeamBOMatchRepository $teamBOMatchRepository
    ): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $status = $statusRepository->find($data['statusId']);
        $gamemode = $gamemodeRepository->find($data['gamemodeId']);
        $caster = $casterRepository->find($data['casterId']);
        $team1 = $teamRepository->find($data['team1Id']);
        $team2 = $teamRepository->find($data['team2Id']);

        $formattedDate = DateTime::createFromFormat('Y-m-d H:i:s', $data['date']);

        $match = new BOMatch();
        $match->setName($data['name']);
        $match->setStatus($status);
        $match->setGamemode($gamemode);
        $match->setDate($formattedDate);
        $match->setBanMap($data['banMap']);
        $match->setCaster($caster);

        $teamBOMatch1 = new TeamBOMatch();
        $teamBOMatch1->setBOMatch($match);
        $teamBOMatch1->setTeam($team1);

        $teamBOMatch2 = new TeamBOMatch();
        $teamBOMatch2->setBOMatch($match);
        $teamBOMatch2->setTeam($team2);

        $matchRepository->save($match, true);
        $teamBOMatchRepository->save($teamBOMatch1, true);
        $teamBOMatchRepository->save($teamBOMatch2, true);

        // TODO : return the match with the team1 and team2, actually not working
        $match = $matchRepository->find($match->getId());

        $jsonBOMatch = $serializer->serialize($match, 'json', ['groups' => 'match:read']);

        return new JsonResponse($jsonBOMatch, Response::HTTP_CREATED, ['accept' => 'json'], true);
    }

    #[Route('/{id}', name: 'app_matches_get_one_match', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function getOneBOMatch(BOMatch $match, SerializerInterface $serializer): JsonResponse
    {
        $jsonBOMatch = $serializer->serialize($match, 'json', ['groups' => 'match:read']);

        return new JsonResponse($jsonBOMatch, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('/{id}', name: 'app_matches_update_match', methods: ['PUT'])]
    #[IsGranted('ROLE_CASTER', message: 'You don\'t have the right to access to this ressource.')]
    public function updateBOMatch(
        BOMatch $match,
        Request $request,
        SerializerInterface $serializer,
        BOMatchRepository $matchRepository,
        StatusRepository $statusRepository,
        GamemodeRepository $gamemodeRepository
    ): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $status = $statusRepository->find($data['statusId']);
        $gamemode = $gamemodeRepository->find($data['gamemodeId']);

        $formattedDate = \DateTime::createFromFormat('Y-m-d H:i:s', $data['date']);

        $match->setName($data['name']);
        $match->setStatus($status);
        $match->setGamemode($gamemode);
        $match->setDate($formattedDate);
        $match->setBanMap($data['banMap']);

        $matchRepository->save($match, true);

        //TODO : return the match with the team1 and team2

        $jsonBOMatch = $serializer->serialize($match, 'json', ['groups' => 'match:read']);

        return new JsonResponse($jsonBOMatch, Response::HTTP_OK, ['accept' => 'json'], true);
    }
}
