<?php

namespace App\Controller;

use App\Entity\Round;
use App\Repository\BOMatchRepository;
use App\Repository\GameRepository;
use App\Repository\MapRepository;
use App\Repository\RoundRepository;
use App\Repository\StatusRepository;
use App\Repository\TeamRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/rounds')]
class RoundController extends AbstractController
{
    #[Route('', name: 'app_rounds_get_rounds', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function getRounds(RoundRepository $roundRepository, SerializerInterface $serializer): JsonResponse
    {
        $rounds = $roundRepository->findAll();
        $jsonRounds = $serializer->serialize($rounds, 'json', ['groups' => 'round:read']);

        return new JsonResponse($jsonRounds, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('', name: 'app_rounds_create_round', methods: ['POST'])]
    #[IsGranted('ROLE_CASTER', message: 'You don\'t have the right to access to this ressource.')]
    public function createRound(
        Request $request,
        SerializerInterface $serializer,
        RoundRepository $roundRepository,
        GameRepository $gameRepository
    ): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $game = $gameRepository->find($data['gameId']);

        $round = new Round();
        $round->setGame($game);
        $round->setRoundNumber($data['roundNumber']);

        $roundRepository->save($round, true);

        $jsonRound = $serializer->serialize($round, 'json', ['groups' => 'round:read']);

        return new JsonResponse($jsonRound, Response::HTTP_CREATED, ['accept' => 'json'], true);
    }

    #[Route('/{id}', name: 'app_rounds_get_one_round', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function getOneRound(Round $round, SerializerInterface $serializer): JsonResponse
    {
        $jsonRound = $serializer->serialize($round, 'json', ['groups' => 'round:read']);

        return new JsonResponse($jsonRound, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('/{id}', name: 'app_rounds_update_round', methods: ['PUT'])]
    #[IsGranted('ROLE_CASTER', message: 'You don\'t have the right to access to this ressource.')]
    public function updateRound(
        Round $round,
        Request $request,
        SerializerInterface $serializer,
        RoundRepository $roundRepository,
        TeamRepository $teamRepository
    ): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $winnerTeam = $teamRepository->find($data['winnerTeamId']);

        $round->setWinnerTeam($winnerTeam);

        $roundRepository->save($round, true);

        $jsonRound = $serializer->serialize($round, 'json', ['groups' => 'round:read']);

        return new JsonResponse($jsonRound, Response::HTTP_OK, ['accept' => 'json'], true);
    }
}
