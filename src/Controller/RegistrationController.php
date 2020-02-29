<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\HashPasswordListener;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

use Doctrine\ORM\EntityManagerInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/api/registration", name="registration")
     */
    public function index(Request $request, EntityManagerInterface $manager, SerializerInterface $serializer)
    {
        $user = new User();
        $user->setLogin($request->request->get("email"));
        $user->setPlainPassword($request->request->get("password"));
        $user->setRoles(['ROLE_FAN']);

        $manager->persist($user);
        $manager->flush();

        // On clone le user pour le renvoyer sans password
        $userClone = clone $user;
        $userClone->setPassword('');

        // Pour pouvoir récupérer le(s) artiste(s) associés aux fans, il faut préciser ça :
        $context['circular_reference_handler'] = function ($object) {
            return $object->getId();
        };

        // Transformation de l'objet Doctrine en JSON
        $data = $serializer->serialize($userClone, 'json', $context);

        return new Response($data, 200, []);
    }
}
