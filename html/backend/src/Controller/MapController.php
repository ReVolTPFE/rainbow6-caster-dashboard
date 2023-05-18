<?php

namespace App\Controller;

use App\Entity\Map;
use App\Repository\MapRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/maps')]
class MapController extends AbstractController
{
    #[Route('', name: 'app_maps_get_maps', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function getMaps(MapRepository $mapRepository, SerializerInterface $serializer): JsonResponse
    {
        $maps = $mapRepository->findAll();
        $jsonMaps = $serializer->serialize($maps, 'json', ['groups' => 'map:read']);

        return new JsonResponse($jsonMaps, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('/{id}', name: 'app_maps_get_one_map', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function getOneMap(Map $map, SerializerInterface $serializer): JsonResponse
    {
        $jsonMap = $serializer->serialize($map, 'json', ['groups' => 'map:read']);

        return new JsonResponse($jsonMap, Response::HTTP_OK, ['accept' => 'json'], true);
    }
}
