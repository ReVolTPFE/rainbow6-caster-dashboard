<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/users')]
class SecurityController extends AbstractController
{
    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    #[Route('/{id}/reset-password', name: 'app_users_update_password', methods: ['PUT'])]
    #[IsGranted('ROLE_USER', message: 'You don\'t have the right to access to this ressource.')]
    public function updatePassword(User $user, Request $request, SerializerInterface $serializer, EntityManagerInterface $manager): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $data['password']));

        $manager->persist($user);

        $manager->flush();

        $jsonUser = $serializer->serialize($user, 'json', ['groups' => 'user:read']);

        return new JsonResponse($jsonUser, Response::HTTP_OK, ['accept' => 'json'], true);
    }
}
