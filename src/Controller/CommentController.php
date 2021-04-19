<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/api/v1.0/comment", name="comment")
     */
    public function index(UserRepository $user_repository): Response
    {
        $user = $user_repository->find($this->getUser());
        $response = new JsonResponse();
        $response->setData([
            "user" => $user->getId()
        ]);
        return $response;
    }
}
