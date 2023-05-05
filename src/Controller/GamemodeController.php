<?php

namespace App\Controller;

use App\Repository\GamemodeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/gamemodes')]
class GamemodeController extends AbstractController
{
    #[Route('', name: 'app_gamemodes_get_gamemodes', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function getGamemodes(GamemodeRepository $gamemodeRepository, SerializerInterface $serializer): JsonResponse
    {
        $gamemodes = $gamemodeRepository->findAll();
        $jsonGamemodes = $serializer->serialize($gamemodes, 'json', ['groups' => 'gamemode:read']);

        return new JsonResponse($jsonGamemodes, Response::HTTP_OK, ['accept' => 'json'], true);
    }
}
