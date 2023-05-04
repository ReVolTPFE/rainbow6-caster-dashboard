<?php

namespace App\Controller;

use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/statuses')]
class StatusController extends AbstractController
{
    #[Route('', name: 'app_statuses_get_statuses', methods: ['GET'])]
    public function getStatuses(StatusRepository $statusRepository, SerializerInterface $serializer): JsonResponse
    {
        $statuses = $statusRepository->findAll();
        $jsonStatuses = $serializer->serialize($statuses, 'json', ['groups' => 'getStatuses']);

        return new JsonResponse($jsonStatuses, Response::HTTP_OK, ['accept' => 'json'], true);
    }
}
