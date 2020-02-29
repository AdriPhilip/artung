<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class IndexController extends AbstractController
{
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/{vueRouting}", requirements={"vueRouting"="^(?!api|_(profiler|wdt)).*"}, name="index")
     * @return Response
     */
    public function indexAction(): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();
        $data = null;
        if (!empty($user)) {
            $userClone = clone $user;
            $userClone->setPlainPassword('');
            $userClone->setPassword('');

            $context['circular_reference_handler'] = function ($object) {
                return $object->getId();
            };

            // Transformation de l'objet Doctrine en JSON
            $data = $this->serializer->serialize($userClone, 'json', $context);
        }

        return $this->render('base.html.twig', [
            'isAuthenticated' => json_encode(!empty($user)),
            'user' => $data ?? json_encode($data),
        ]);
    }
}
