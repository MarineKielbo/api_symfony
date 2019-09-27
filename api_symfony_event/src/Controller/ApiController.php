<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index(SerializerInterface $serializer)
    {
        $event = new Event();
        $event->setDateDebut(\DateTime::createFromFormat('Y-m-d', "2018-09-09"));
        $event->setDateFin(\DateTime::createFromFormat('Y-m-d', "2018-09-12"));
        $event->setNombrePlaces(100);

        $data = $serializer->serialize($event, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}