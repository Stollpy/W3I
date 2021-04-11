<?php

namespace App\Controller;

use App\Service\MainAccountService;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaceBookController extends AbstractController
{
    /**
     * @Route("/facebook", name="face_book")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/FaceBookController.php',
        ]);
    }

    /**
     * @Route("/connect/facebook", name="connect_facebook")
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('facebook_main')
            ->redirect([
                'public_profile',
                'email',
                //instagram
                'instagram_basic',
                'instagram_manage_comments',
                'instagram_manage_insights',
                'instagram_content_publish',
                ' ids_for_business',
                //
                'pages_show_list',
                'pages_read_engagement',
                'pages_show_list',
                'pages_manage_engagement',
                'publish_video',
                'pages_messaging',
            ]);
    }
    /**
     * @Route("/connect/facebook/check", name="connect_facebook_check")
     */
    public function connectCheckAction(ClientRegistry $clientRegistry, MainAccountService $main_account_service)
    {
        $access = $clientRegistry->getClient('facebook_main')->getAccessToken();
        $main_account_service->createAccount($access);

        $response = new JsonResponse();
        if(!$access){
            $response->setData([
                'success' => 'Votre compte à été connecté à W3I',
                'access_token' => $access
            ]);
        }else{
            $response->setData([
                'error' => 'Erreur lors de l\'authentification via Facebook'
            ]);
        }

        new LogiqueException('Corrupted logic');
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(Request $request)
    {
        $data = $request->toArray();
        var_dump($data['data']);
        $responce = new JsonResponse();
        $responce->setData([
            'data' => 'Tout est op'
        ]);
        return $responce;
    }
}
