<?php

namespace App\Controller;

use App\Repository\FanAccountRepository;
use App\Repository\LocationRepository;
use App\Repository\MainAccountRepository;
use App\Service\MediaService;
use App\Service\UploadService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController
{
    /**
     ***************************************************************
     * Route permettant de publier un média sur un compte fan
     * instagram relié au compte principal.
     ***************************************************************
     * @Route("/api/v1.0/media/upload", name="media.index", methods={"POST"})
     * @param Request $request
     * @param MediaService $media_service
     * @return JsonResponse
     */
    public function index(Request $request, MediaService $media_service, UploadService $upload_service): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $file = $request->files->get('file');

        if(!$data['media']['url']){
            $data['media']['url'] = $upload_service->uploadPulibc($file);
        }

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

    /**
     * @Route("/api/v1.0/media", name="media.home", methods={"GET"})
     * @param LocationRepository $location_repository
     * @param FanAccountRepository $fan_account_repository
     * @return JsonResponse
     */
    public function mediaHome(LocationRepository $location_repository, FanAccountRepository $fan_account_repository, MainAccountRepository $main_account_repository): JsonResponse
    {
        $main_account = $main_account_repository->findOneBy(["user" => $this->getUser()]);
        $fan_accounts = $fan_account_repository->findBy(["main_account" => $main_account]);
        $locations = $location_repository->findAll();

        $data_fan_account = [];
        foreach ($fan_accounts as $fan_account){
            $data = [];

            $data['id'] = $fan_account->getId();
            $data['pseudo'] = $fan_account->getPseudo();

            array_push($data_fan_account, $data);
        }

        return $this->json([
            "fan_account" => $data_fan_account,
            "locations" => $locations,
        ]);
    }
}
