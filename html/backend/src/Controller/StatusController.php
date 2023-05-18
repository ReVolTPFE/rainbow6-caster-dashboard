<?php

namespace App\Controller;

use App\Repository\StatusRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/statuses')]
class StatusController extends AbstractController
{
    #[Route('', name: 'app_statuses_get_statuses', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function getStatuses(StatusRepository $statusRepository, SerializerInterface $serializer): JsonResponse
    {
        $statuses = $statusRepository->findAll();
        $jsonStatuses = $serializer->serialize($statuses, 'json', ['groups' => 'status:read']);

        return new JsonResponse($jsonStatuses, Response::HTTP_OK, ['accept' => 'json'], true);
    }
}
