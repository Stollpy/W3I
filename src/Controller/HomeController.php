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
        $user = $user_repository->find($this->getUser());

        return $this->json([
            'user' => $user
        ]);
    }
}
