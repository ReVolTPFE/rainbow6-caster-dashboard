<?php

namespace App\Controller;

use App\Repository\GamemodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/gamemodes')]
class GamemodeController extends AbstractController
{
    #[Route('', name: 'app_gamemodes_get_gamemodes', methods: ['GET'])]
    public function getGamemodes(GamemodeRepository $gamemodeRepository, SerializerInterface $serializer): JsonResponse
    {
        $gamemodes = $gamemodeRepository->findAll();
        $jsonGamemodes = $serializer->serialize($gamemodes, 'json', ['groups' => 'getGamemodes']);

        return new JsonResponse($jsonGamemodes, Response::HTTP_OK, ['accept' => 'json'], true);
    }
}
