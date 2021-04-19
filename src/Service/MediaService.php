<?php


namespace App\Service;


use App\Repository\FanAccountRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MediaService
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $base_url;

    /**
     * @var AccountFanRepository
     */
    private $account_fan_repository;

    /**
     * MediaService constructor.
     * @param HttpClientInterface $client
     * @param FanAccountRepository $account_fan_repository
     */
    public function __construct(HttpClientInterface $client, FanAccountRepository $account_fan_repository)
    {
        $this->client = $client;
        $this->base_url = 'https://graph.facebook.com/v10.0/';
        $this->account_fan_repository = $account_fan_repository;
    }

    /**
     ***********************************************************
     * Cette méthode permet de publié un média
     * depuis un compte fan, d'un object média renvoyant l'url
     * de l'image à publié ainsi qu'une description associé
     ***********************************************************
     * @param array $data
     * @return boolean
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function publishMedia(array $data): bool
    {
        foreach ($data['locations'] as $localisation){
            $fan_account = $this->account_fan_repository->findOneBy(["id" => $data['id_fan']]);
            $access_token = $fan_account->getAccessToken();
            $id_page_insta = $fan_account->getIdPageInsta();
            $this->publishContainer($id_page_insta, $data['media'], $access_token);
        }

        return true;
    }

    /**
     *********************************************
     * Cette Méthode permet de créer un container
     * publiable sur une page instagram
     *********************************************
     * @param string $id_page_insta
     * @param array $object_media
     * @param string $access_token
     * @return mixed
     * @throws \Exception
     */
    public function createContainerPublish(string $id_page_insta, array $object_media, string $access_token)
    {
        $response = $this->client->request(
            'POST',
            $this->base_url.$id_page_insta.'/media?image_url='.$object_media['url'].'&caption='.$object_media['description'].'&access_token='.$access_token
        );
        $data = json_decode($response->getContent(), true);
        return $data['id'];
    }

    /**
     * *************************************************************
     * Cette méthode permet de publier un container,
     * elle se base sur la méthode createContainerPublish()
     * pour créer un container publiable puis publie se container
     *************************************************************
     * @param string $id_page_insta
     * @param array $object_media
     * @param string $access_token
     * @return \Exception|mixed
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function publishContainer(string $id_page_insta, array $object_media, string $access_token)
    {
        try{

            $id_container = $this->createContainerPublish($id_page_insta, $object_media, $access_token);

            $response = $this->client->request(
                'POST',
                $this->base_url.$id_page_insta.'/media_publish?creation_id='.$id_container.'&access_token='.$access_token
            );

            $data = $response->toArray();
            return $data['id'];

        }catch(Exception $exception){
            return new \Exception($exception);
        }
    }
}