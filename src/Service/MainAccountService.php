<?php


namespace App\Service;


use App\Entity\MainAccount;
use App\Repository\MainAccountRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MainAccountService
{
    /**
     * @var MainAccount
     */
    private $main_account;

    /**
     * @var MainAccountRepository
     */
    private $main_account_repository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var UserRepository
     */
    private $user_repository;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * MainAccountService constructor.
     * @param MainAccount $main_account
     * @param MainAccountRepository $main_account_repository
     * @param EntityManagerInterface $manager
     * @param UserRepository $user_repository
     * @param Security $security
     * @param HttpClientInterface $client
     */
    public function __construct(MainAccount $main_account, MainAccountRepository $main_account_repository, EntityManagerInterface $manager,
                                UserRepository $user_repository, Security $security, HttpClientInterface  $client){

        $this->main_account = $main_account;
        $this->main_account_repository = $main_account_repository;
        $this->manager = $manager;
        $this->user_repository = $user_repository;
        $this->security = $security;
        $this->client = $client;
    }

    /**
     * *************************************************
     * Méthode permettant de créer un nouveau
     * compte principal depuis un access token renvoyé
     * par api graph de FaceBook
     * *************************************************
     * @param string $access_token
     * @param string $pseudo
     */
    public function createAccount(string $access_token){

        // Importation des données requise
        $user = $this->user_repository->find($this->security->getUser());
        $facebook_page = $this->fetchIdFaceBookPage($access_token);
        $id_facebook_page = $facebook_page['id'];
        $pseudo = $facebook_page['pseudo'];
        $id_instagram_page = $this->fetchIdInstagramPage($access_token, $id_facebook_page);

        // Création d'un compte principal
        $mainAccount = new $this->main_account;
        $mainAccount->setAccessToken($access_token);
        $mainAccount->setPseudo($pseudo);
        $mainAccount->setUser($user);
        $mainAccount->setIdFacebookPage($id_facebook_page);
        $mainAccount->setIdInstagramPage($id_instagram_page);

        $this->manager->persist($mainAccount);
        $this->manager->flush();
    }

    /**
     * ***********************************************************
     * Methode permettant de recupérer l'id de la page
     * FaceBook de l'utilisateur, cette methode requête
     * api graph de FaceBook. Elle retourne l'id de la page
     * en question ainsi que le nom de cette dernier en tableau
     * associatif
     * ***********************************************************
     * @param string $access_token
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function fetchIdFaceBookPage(string $access_token){
        $data = [];

        $responce = $this->client->request(
          'GET',
          'https://graph.facebook.com/v10.0/me/accounts?access_token='.$access_token
        );

        $content =  json_decode($responce->getContent(),true);

        $data['id'] = $content["data"]["id"];
        $data['pseudo'] = $content["data"]["name"];
        return $data;
    }

    /**
     * ******************************************************
     * Methode permettant de recupérer l'id de la page
     * Instagram de l'utilisateur, cette methode requête
     * api graph de Instagram. Elle retourne l'id de la page
     * en question
     * *******************************************************
     * @param string $access_token
     * @param int $id_facebook_page
     * @return mixed
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function fetchIdInstagramPage(string $access_token, int $id_facebook_page){
        $responce = $this->client->request(
            'GET',
            'https://graph.facebook.com/v10.0/'.$id_facebook_page.'?fields=instagram_business_account&access_token=?access_token='.$access_token
        );
        $content =  json_decode($responce->getContent(),true);
        return $content["instagram_business_account"]["id"];
    }
}