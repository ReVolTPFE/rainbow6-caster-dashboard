<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\BOMatchRepository;
use App\Repository\GameRepository;
use App\Repository\MapRepository;
use App\Repository\StatusRepository;
use App\Repository\TeamRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/games')]
class GameController extends AbstractController
{
    #[Route('', name: 'app_games_get_games', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function getGames(GameRepository $gameRepository, SerializerInterface $serializer): JsonResponse
    {
        $games = $gameRepository->findAll();
        $jsonGames = $serializer->serialize($games, 'json', ['groups' => 'game:read']);

        return new JsonResponse($jsonGames, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('', name: 'app_games_create_game', methods: ['POST'])]
    #[IsGranted('ROLE_CASTER', message: 'You don\'t have the right to access to this ressource.')]
    public function createGame(
        Request $request,
        SerializerInterface $serializer,
        GameRepository $gameRepository,
        MapRepository $mapRepository,
        StatusRepository $statusRepository,
        BOMatchRepository $matchRepository
    ): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $map = $mapRepository->find($data['mapId']);
        $status = $statusRepository->find($data['statusId']);
        $match = $matchRepository->find($data['matchId']);

        $game = new Game();
        $game->setMap($map);
        $game->setStatus($status);
        $game->setBOMatch($match);

        $gameRepository->save($game, true);

        $jsonGame = $serializer->serialize($game, 'json', ['groups' => 'game:read']);

        return new JsonResponse($jsonGame, Response::HTTP_CREATED, ['accept' => 'json'], true);
    }

    #[Route('/{id}', name: 'app_games_get_one_game', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function getOneGame(Game $game, SerializerInterface $serializer): JsonResponse
    {
        $jsonGame = $serializer->serialize($game, 'json', ['groups' => 'game:read']);

        return new JsonResponse($jsonGame, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('/{id}', name: 'app_games_update_game', methods: ['PUT'])]
    #[IsGranted('ROLE_CASTER', message: 'You don\'t have the right to access to this ressource.')]
    public function updateGame(
        Game $game,
        Request $request,
        SerializerInterface $serializer,
        GameRepository $gameRepository,
        StatusRepository $statusRepository,
        TeamRepository $teamRepository
    ): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $status = $statusRepository->find($data['statusId']);
        $team = $teamRepository->find($data['winnerTeamId']);

        $game->setStatus($status);
        $game->setWinnerTeam($team);

        $gameRepository->save($game, true);

        $jsonGame = $serializer->serialize($game, 'json', ['groups' => 'game:read']);

        return new JsonResponse($jsonGame, Response::HTTP_OK, ['accept' => 'json'], true);
    }
}
