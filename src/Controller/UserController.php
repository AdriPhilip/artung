<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/user")
 */
class UserController extends AbstractController
{
  /**
   * @Route("/{id}/edit", name="user_edit", methods={"PUT"})
   */
  public function edit(Request $request, UserRepository $userRepository): Response
  {
    // Récupération de la valeur de {id} à partir de la route
    $id = $request->get('id');

    $user = $userRepository->findOneBy(['id' => $id]);

    $body = json_decode($request->getContent(), true);

    // On redéfinit les valeurs du user
    $user->setLogin($body['username']);

    $this->getDoctrine()->getManager()->flush();

    // Envoi de la réponse
    return new Response("Utilisateur modifié", Response::HTTP_OK, []);
  }

  /**
   * @Route("/{id}", name="user_delete", methods={"DELETE"})
   * 
   */
  public function delete(Request $request, UserRepository $userRepository): Response
  {
    // Récupération de la valeur de {id} à partir de la route
    $id = $request->get('id');

    $user = $userRepository->findOneBy(['id' => $id]);

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($user);
    $entityManager->flush();

    if (!$userRepository->findOneBy(['id' => $id])) {
      // Envoi de la réponse
      return new Response("Profil supprimé", Response::HTTP_OK, []);
    } else {
      return new Response("Echec de la suppression du profil", 500, []);
    }


    return new Response("Utilisateur supprimé", Response::HTTP_OK, []);
  }
}
