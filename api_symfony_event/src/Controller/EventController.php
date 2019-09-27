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

/**
 * @Route("/api/events")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="list_event", methods={"GET"})
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
     * @Route("/{id}", name="show_event", methods={"GET"})
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
     * @Route("/", name="add_event", methods={"POST"})
     */
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $event = $serializer->deserialize($request->getContent(), Event::class, 'json');
        $entityManager->persist($event);
        $entityManager->flush();
        $data = [
            'status' => 201,
            'message' => "L'evenement' a bien été ajouté"
        ];
        return new JsonResponse($data, 201);
    }
}
