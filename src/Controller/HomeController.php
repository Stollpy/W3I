<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/api/v1.0/home", name="home.index")
     */
    public function index(UserRepository $user_repository): Response
    {

        return $this->json([
            'id_user' => $this->getUser()->getId(),
            'firstname' => $this->getUser()->getFirstname(),
            'main_accounts' => $this->getUser()->getMainAccounts()
        ]);
    }
}
