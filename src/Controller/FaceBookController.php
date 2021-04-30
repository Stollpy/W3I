<?php

namespace App\Controller;

use App\Service\MainAccountService;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FaceBookController extends AbstractController
{
    /**
     * @Route("/api/v1.0/connect/facebook", name="connect_facebook")
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('facebook_main')
            ->redirect([
                'public_profile',
                'email',
                'instagram_basic',
                'instagram_manage_comments',
                'instagram_manage_insights',
                'instagram_content_publish',
                ' ids_for_business',
                'pages_show_list',
                'pages_read_engagement',
                'pages_show_list',
                'pages_manage_engagement',
                'publish_video',
                'pages_messaging',
            ]);
    }
    /**
     * @Route("/api/v1.0/connect/facebook/check", name="connect_facebook_check")
     */
    public function connectCheckAction(ClientRegistry $clientRegistry, MainAccountService $main_account_service)
    {
        $access = $clientRegistry->getClient('facebook_main')->getAccessToken();
        $main_account_service->createAccount($access);

        $response = new JsonResponse();
        if($access){
            return $response->setData([
                'success' => 'Votre compte à été connecté à W3I',
                'access_token' => $access
            ]);
        }else{
            return $response->setData([
                'error' => 'Erreur lors de l\'authentification via Facebook'
            ]);
        }

        throw new \LogiqueException('Corrupted logic');
    }
}
