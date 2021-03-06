<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Fans;
use App\Entity\Artists;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

use Doctrine\ORM\EntityManagerInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/api/registration/{type}", name="registration")
     */
    public function index(Request $request, EntityManagerInterface $manager, SerializerInterface $serializer)
    {
        $user = new User();
        $data = json_decode($request->getContent(), true);
        $user->setLogin($data["username"]);
        $user->setPlainPassword($data["password"]);

        // On récupère le type de compte (artist ou fan) pour définir le role
        $type = $request->get('type');
        if ($type == 'artist') {
            $user->setRoles(["ROLE_ARTIST"]);
            $artist = new Artists();
            $artist->setNickname($data['nickname']);
            $artist->setUser($user);
            $manager->persist($artist);
        } else if ($type == 'fan') {
            $user->setRoles(["ROLE_FAN"]);
            $fan = new Fans();
            $fan->setNickname($data['nickname']);
            $fan->setUser($user);
            $manager->persist($fan);
        } else if ($type == 'admin') {
            $user->setRoles(['ROLE_ADMIN']);
        }

        $manager->persist($user);
        $manager->flush();

        // On clone le user pour le renvoyer sans password
        $userClone = clone $user;
        $userClone->setPlainPassword('');
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
