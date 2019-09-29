<?php

namespace App\Controller;

use App\Repository\UserInscriptionRepository;
use App\Entity\UserInscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api")
 */
class UserInscriptionController extends AbstractController
{

    /**
     * @Route("/user/{id}", name="show_user", methods={"GET"})
     */
    public function show(UserInscription $userInscription, UserInscriptionRepository $userInscriptionRepository, SerializerInterface $serializer)
    {
        $userInscription = $userInscriptionRepository->find($userInscription->getId());
        $data = $serializer->serialize($userInscription, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/user", name="add_user", methods={"POST"})
     */
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $user = $serializer->deserialize($request->getContent(), UserInscription::class, 'json');
        $errors = $validator->validate($user);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->persist($user);
        $entityManager->flush();
        $data = [
            'status' => 201,
            'message' => "L'utilisateur a bien été créer"
        ];
        return new JsonResponse($data, 201);
    }
}
