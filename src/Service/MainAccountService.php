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
    private $main_account;
    private $main_account_repository;
    private $manager;
    private $user_repository;
    private $security;
    private $client;

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
     * Méthode permettant de créer un nouveau
     * compte principal
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

    public function fetchIdFaceBookPage(string $access_token){
        $data = [];

        $responce = $this->client->request(
          'GET',
          'https://graph.facebook.com/v10.0/me/accounts?access_token='.$access_token
        );
        $content =  $responce->toArray();

        $data['id'] = $content["data"]["id"];
        $data['pseudo'] = $content["data"]["name"];
        return $data;
    }

    public function fetchIdInstagramPage(string $access_token, int $id_facebook_page){
        $responce = $this->client->request(
            'GET',
            'https://graph.facebook.com/v10.0/'.$id_facebook_page.'?fields=instagram_business_account&access_token=?access_token='.$access_token
        );
        $content =  $responce->toArray();
        return $content["instagram_business_account"]["id"];
    }
}