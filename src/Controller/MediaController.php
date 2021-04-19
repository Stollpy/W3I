<?php

namespace App\Controller;

use App\Service\MediaService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController
{
    /**
     * @Route("/api/v1.0/media", name="media.index", methods={"POST"})
     * @param Request $request
     * @param MediaService $media_service
     */
    public function index(Request $request, MediaService $media_service): Response
    {
        $data = json_decode($request->getContent(), true);
        $bool = $media_service->publishMedia($data);
        if($bool == true){
            return new JsonResponse([
                "message" => "Vos medias on bien ete publie",
                "code" => 201,
            ]);
        }else{
            return new JsonResponse([
                "message" => "Une erreur inconnue c'est produite, veuillez contacter le developpeur",
                "code" => 500,
            ]);
        }

        throw new \LogiqueException('Error Logique corrupted');
    }
}
