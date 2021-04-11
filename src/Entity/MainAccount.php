<?php

namespace App\Entity;

use App\Repository\MainAccountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MainAccountRepository::class)
 */
class MainAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $access_token;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="mainAccounts")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $id_page_fb;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $id_page_insta;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->access_token;
    }

    public function setAccessToken(string $access_token): self
    {
        $this->access_token = $access_token;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIdPageFb(): ?string
    {
        return $this->id_page_fb;
    }

    public function setIdPageFb(string $id_page_fb): self
    {
        $this->id_page_fb = $id_page_fb;

        return $this;
    }

    public function getIdPageInsta(): ?string
    {
        return $this->id_page_insta;
    }

    public function setIdPageInsta(string $id_page_insta): self
    {
        $this->id_page_insta = $id_page_insta;

        return $this;
    }
}
