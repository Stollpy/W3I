<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPersister implements DataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encode;


    /**
     * UserPersister constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encode){
        $this->manager = $manager;
        $this->encode = $encode;
    }

    /**
     * Vient déterminer si $data
     * est une instance de User.
     * @param $data
     * @return bool
     */
    public function supports($data): bool
    {
        return $data instanceof User;
    }

    /**
     * Si $data est un instance de User,
     * On vient donc encoder son mot de passe si le champ mot de passe existe.
     * @param $data
     * @return object|void
     */
    public function persist($data)
    {
        if($data->getPassword()){
            $data->setPassword($this->encode->encodePassword($data, $data->getPassword()));
            $data->eraseCredentials();
        }
        $this->manager->persist($data);
        $this->manager->flush();
    }

    /**
     * Cette fonction sert à manipuler $data
     * avant sa suppression.
     * @param $data
     */
    public function remove($data)
    {
        $this->manager->remove($data);
        $this->manager->flush();
    }
}