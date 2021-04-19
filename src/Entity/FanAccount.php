<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FanAccountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     normalizationContext={"groups": {"fanAccount:read"}},
 *     denormalizationContext={"groups": {"fanAccount:write"}}
 * )
 * @ORM\Entity(repositoryClass=FanAccountRepository::class)
 */
class FanAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MainAccount::class, inversedBy="fanAccounts")
     */
    private $main_account;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $id_page_insta;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $id_page_fb;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $access_token;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainAccount(): ?MainAccount
    {
        return $this->main_account;
    }

    public function setMainAccount(?MainAccount $main_account): self
    {
        $this->main_account = $main_account;

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

    public function getIdPageFb(): ?string
    {
        return $this->id_page_fb;
    }

    public function setIdPageFb(string $id_page_fb): self
    {
        $this->id_page_fb = $id_page_fb;

        return $this;
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
}
