<?php


namespace App\Service;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommentService
{
    private $client;
    private $base_url;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->base_url = 'https://graph.facebook.com/v10.0/';
    }

    public function getAllMentions()
    {

    }
}