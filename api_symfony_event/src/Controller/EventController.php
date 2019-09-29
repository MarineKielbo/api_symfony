<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Entity\Event;
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
class EventController extends AbstractController
{
    /**
     * @Route("/events", name="list_event", methods={"GET"})
     */
    public function index(EventRepository $eventRepository, SerializerInterface $serializer)
    {
        $events = $eventRepository->findAll();
        $data = $serializer->serialize($events, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/event/{id}", name="show_event", methods={"GET"})
     */
    public function show(Event $event, EventRepository $eventRepository, SerializerInterface $serializer)
    {
        $event = $eventRepository->find($event->getId());
        $data = $serializer->serialize($event, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/event", name="add_event", methods={"POST"})
     */
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $event = $serializer->deserialize($request->getContent(), Event::class, 'json');
        $errors = $validator->validate($event);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->persist($event);
        $entityManager->flush();
        $data = [
            'status' => 201,
            'message' => "L'évenement a bien été ajouté"
        ];
        return new JsonResponse($data, 201);
    }

    /**
     * @Route("/event/{id}", name="update_event", methods={"PUT"})
     */
    public function update(Request $request, SerializerInterface $serializer, Event $event, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $eventUpdate = $entityManager->getRepository(Event::class)->find($event->getId());
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value){
            if($key && !empty($value)) {
                $name = ucfirst($key);
                $setter = 'set'.$name;
                $eventUpdate->$setter($value);
            }
        }
        $errors = $validator->validate($eventUpdate);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->flush();
        $data = [
            'status' => 200,
            'message' => "L'évenement a bien été mis à jour"
        ];
        return new JsonResponse($data);
    }

     /**
     * @Route("/event/{id}", name="delete_event", methods={"DELETE"})
     */
    public function delete(Event $event, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($event);
        $entityManager->flush();
        return new Response(null, 204);
    }
}
