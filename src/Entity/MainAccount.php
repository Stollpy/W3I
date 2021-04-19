<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MainAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups": {"mainAccount:read"}},
 *     denormalizationContext={"groups": {"mainAccount:write"}}
 * )
 * @ORM\Entity(repositoryClass=MainAccountRepository::class)
 */
class MainAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read", "mainAccount:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read", "mainAccount:read", "mainAccount:write"})
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "mainAccount:read", "mainAccount:write"})
     */
    private $access_token;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="mainAccounts")
     * @Groups({"mainAccount:read", "mainAccount:write"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "mainAccount:read", "mainAccount:write"})
     */
    private $id_page_fb;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "mainAccount:read", "mainAccount:write"})
     */
    private $id_page_insta;

    /**
     * @ORM\OneToMany(targetEntity=FanAccount::class, mappedBy="main_account")
     * @Groups({"user:read", "mainAccount:read", "mainAccount:write"})
     */
    private $fanAccounts;

    public function __construct()
    {
        $this->fanAccounts = new ArrayCollection();
    }


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

    /**
     * @return Collection|FanAccount[]
     */
    public function getFanAccounts(): Collection
    {
        return $this->fanAccounts;
    }

    public function addFanAccount(FanAccount $fanAccount): self
    {
        if (!$this->fanAccounts->contains($fanAccount)) {
            $this->fanAccounts[] = $fanAccount;
            $fanAccount->setMainAccount($this);
        }

        return $this;
    }

    public function removeFanAccount(FanAccount $fanAccount): self
    {
        if ($this->fanAccounts->removeElement($fanAccount)) {
            // set the owning side to null (unless already changed)
            if ($fanAccount->getMainAccount() === $this) {
                $fanAccount->setMainAccount(null);
            }
        }

        return $this;
    }
}
