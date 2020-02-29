<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/api")
 */
final class SecurityController extends AbstractController
{
  /** @var SerializerInterface */
  private $serializer;

  public function __construct(SerializerInterface $serializer)
  {
    $this->serializer = $serializer;
  }

  /**
   * @Route("/login", name="login")
   */
  public function loginAction(SerializerInterface $serializer): JsonResponse
  {
    /** @var User $user */
    $user = $this->getUser();
    if ($user) {
      $userClone = clone $user;
      $userClone->setPassword('');

      // Pour pouvoir récupérer le(s) artiste(s) associés aux fans, il faut préciser ça :
      $context['circular_reference_handler'] = function ($object) {
        return $object->getId();
      };

      // Transformation de l'objet Doctrine en JSON
      $data = $serializer->serialize($userClone, 'json', $context);

      return new JsonResponse($data, Response::HTTP_OK, [], true);
    } else {
      return new JsonResponse("Pas de user trouvé", 500, [], false);
    }
  }

  /**
   * @throws RuntimeException
   *
   * @Route("/logout", name="logout")
   */
  public function logoutAction(): void
  {
    throw new RuntimeException('This should not be reached!');
  }
}
