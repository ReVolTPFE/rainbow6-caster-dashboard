<?php

namespace App\Controller;

use App\Entity\Caster;
use App\Entity\User;
use App\Repository\CasterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/casters')]
class CasterController extends AbstractController
{
    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    #[Route('', name: 'app_casters_get_casters', methods: ['GET'])]
    public function getCasters(CasterRepository $casterRepository, SerializerInterface $serializer): JsonResponse
    {
        $casters = $casterRepository->findAll();
        $jsonCasters = $serializer->serialize($casters, 'json');

        return new JsonResponse($jsonCasters, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('', name: 'app_casters_create_caster', methods: ['POST'])]
    public function createCaster(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $data['password']));
        $user->setRoles(['ROLE_CASTER']);

        $caster = new Caster();
        $caster->setNickname($data['nickname']);
        $caster->setFirstname($data['firstname']);
        $caster->setLastname($data['lastname']);
        $caster->setUser($user);

        $manager->persist($user);
        $manager->persist($caster);

        $manager->flush();

        $jsonCaster = $serializer->serialize($caster, 'json');

        return new JsonResponse($jsonCaster, Response::HTTP_CREATED, ['accept' => 'json'], true);
    }



    #[Route('/{id}', name: 'app_casters_get_one_caster', methods: ['GET'])]
    public function getOneCaster(Caster $caster, SerializerInterface $serializer): JsonResponse
    {
        $jsonCaster = $serializer->serialize($caster, 'json');

        return new JsonResponse($jsonCaster, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('/{id}', name: 'app_casters_update_caster', methods: ['PUT'])]
    public function updateCaster(Caster $caster, Request $request, SerializerInterface $serializer, EntityManagerInterface $manager): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $user = $caster->getUser();

        $caster->setNickname($data['nickname']);
        $caster->setFirstname($data['firstname']);
        $caster->setLastname($data['lastname']);

        $manager->persist($user);
        $manager->persist($caster);

        $manager->flush();

        $jsonCaster = $serializer->serialize($caster, 'json');

        return new JsonResponse($jsonCaster, Response::HTTP_OK, ['accept' => 'json'], true);
    }
}
