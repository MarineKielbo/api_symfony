<?php

namespace App\Controller;

use App\Repository\UserEventRepository;
use App\Entity\UserEvent;
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
class UserEventController extends AbstractController
{

    /**
     * @Route("/inscription/{id}", name="show_inscription", methods={"GET"})
     */
    public function show(UserEvent $userEvent, UserEventRepository $userEventRepository, SerializerInterface $serializer)
    {
        $userEvent = $userEventRepository->find($userEvent->getId());
        $data = $serializer->serialize($userEvent, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/inscription", name="add_inscription", methods={"POST"})
     */
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $inscription = $serializer->deserialize($request->getContent(), UserEvent::class, 'json');
        $event_id = $request->get('event_id');
        $user_inscription_id = $request->get('user_inscription_id');
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('App\Entity\Event')->findOneBy(array('id' => $event_id));
        $user_inscription = $em->getRepository('App\Entity\UserInscription')->findOneBy(array('id' => $user_inscription_id));
        $inscription->setEvent($event);
        $inscription->setUserInscription($user_inscription);
        if ($event->getNombrePlaces() >= 1)
        {
            $nbr_places = $event->getNombrePlaces()- 1;
            $event->setNombrePlaces($nbr_places);
            $em->persist($event);
            $em->flush();
            $errors = $validator->validate($inscription);
            if(count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                    'Content-Type' => 'application/json'
                ]);
            }
            $entityManager->persist($inscription);
            $entityManager->flush();
            $data = [
                'status' => 201,
                'message' => "L'inscription a bien été créer"
            ];
            return new JsonResponse($data, 201);
        }
        else
        {
            $data = [
                'status' => 201,
                'message' => "L'evenement est complet."
            ];
            return new JsonResponse($data, 201);
        }
    }
}
