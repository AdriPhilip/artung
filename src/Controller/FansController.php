<?php

namespace App\Controller;

use App\Entity\Fans;
use App\Repository\ArtistsRepository;
use App\Repository\FansRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/fans")
 */
class FansController extends AbstractController
{
    /**
     * @Route("/", name="fans_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN", message="Vous devez être enregistré en tant qu'administrateur pour accéder à ces données")
     */
    public function index(FansRepository $fansRepository, SerializerInterface $serializer): Response
    {
        $fans = $fansRepository->findAll();

        // Pour pouvoir récupérer le(s) artiste(s) associés aux fans, il faut préciser ça :
        $context['circular_reference_handler'] = function ($object) {
            return $object->getId();
        };

        // Transformation de l'objet Doctrine en JSON
        $data = $serializer->serialize($fans, 'json', $context);

        $response = new Response(
            'Fans',
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
        $response->setContent($data);
        return $response;
    }

    /**
     * @Route("/{id}", name="fans_show", methods={"GET"})
     * @IsGranted("ROLE_FAN", message="Vous devez être enregistré en tant que fan pour accéder à ces données")
     */
    public function show(Request $request, FansRepository $fansRepository, SerializerInterface $serializer): Response
    {
        // Récupération de la valeur de {id} à partir de la route
        $id = $request->get('id');
        $fan = $fansRepository->findOneBy(['id' => $id]);

        // Pour pouvoir récupérer le(s) artiste(s) associés au fan, il faut préciser ça :
        $context['circular_reference_handler'] = function ($object) {
            return $object->getId();
        };

        $data = $serializer->serialize($fan, 'json', $context);
        $response = new Response(
            'Fan',
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );
        $response->setContent($data);
        return $response;
    }

    /**
     * @Route("/{id}/edit", name="fans_edit", methods={"PUT"})
     * @IsGranted("ROLE_FAN", message="Vous devez être enregistré en tant que fan pour effectuer cette action")
     */
    public function edit(Request $request, FansRepository $fansRepository): Response
    {
        // Récupération de la valeur de {id} à partir de la route
        $id = $request->get('id');

        $fan = $fansRepository->findOneBy(['id' => $id]);

        $body = json_decode($request->getContent(), true);

        // On redéfinit toutes les valeurs du fan
        $fan->setNickname($body['nickname']);
        $fan->setPhoto($body['photo']);

        $this->getDoctrine()->getManager()->flush();

        // Envoi de la réponse
        return new Response("Profil modifié", Response::HTTP_OK, []);
    }

    /**
     * @Route("/{id}/addfav/{artistId}", name="fans_add_fav", methods={"PUT"})
     * @IsGranted("ROLE_FAN", message="Vous devez être enregistré en tant que fan pour effectuer cette action")
     */
    public function addFav(Request $request, FansRepository $fansRepository, ArtistsRepository $artistsRepository): Response
    {
        // Récupération de la valeur de {id} (correspondant au fan) à partir de la route
        $id = $request->get('id');
        $artistId = $request->get('artistId');

        $fan = $fansRepository->findOneBy(['id' => $id]);
        $artist = $artistsRepository->findOneBy(['id' => $artistId]);

        // On redéfinit toutes les valeurs du fan
        $fan->addFavori($artist);

        $this->getDoctrine()->getManager()->flush();

        // Envoi de la réponse
        return new Response("Favoris ajouté", Response::HTTP_OK, []);
    }

    /**
     * @Route("/{id}", name="fans_delete", methods={"DELETE"})
     * @IsGranted("ROLE_FAN", message="Vous devez être enregistré en tant que fan pour effectuer cette action")
     */
    public function delete(Request $request, FansRepository $fansRepository): Response
    {
        $id = $request->get('id');
        $fan = $fansRepository->findOneBy(['id' => $id]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($fan);
        $entityManager->flush();

        if (!$fansRepository->findOneBy(['id' => $id])) {
            // Envoi de la réponse
            return new Response("Profil supprimé", Response::HTTP_OK, []);
        } else {
            return new Response("Echec de la suppression du profil", 500, []);
        }
    }
}
