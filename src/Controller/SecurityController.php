<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/v1.0/login", name="security_login", methods={"POST"})
     */
    public function login(IriConverterInterface $iriConverter)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->json([
                'error' => 'Invalid login request'
            ], 400);
        }

        return $this->json([
            'location_user' => $iriConverter->getIriFromItem($this->getUser()),
            'location_individual' => $iriConverter->getIriFromItem($this->getUser()),
        ]);
    }

    /**
     * @Route("/api/v1.0/logout", name="security_logout")
     */
    public function logout()
    {
        throw new \Exception('should not be reached');
    }
}
