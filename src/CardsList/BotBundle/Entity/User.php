<?php

namespace CardsList\BotBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(
 *     name="user",
 *     indexes={@ORM\Index(name="username", columns={"username"})},
 *     options={"collate"="utf8mb4_unicode_520_ci", "charset"="utf8mb4"})
 * )
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_bot", type="boolean", nullable=true, options={"default"=false})
     */
    private $isBot = false;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false, options={"fixed" = true,"default"=""})
     */
    private $firstName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true, options={"fixed" = true})
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=191, nullable=true, options={"fixed" = true})
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="language_code", type="string", length=10, nullable=true, options={"fixed" = true})
     */
    private $languageCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="CardsList\BotBundle\Entity\Chat", inversedBy="user")
     * @ORM\JoinTable(name="user_chat",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="chat_id", referencedColumnName="id")
     *   }
     * )
     */
    private $chat;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CardsList\BotBundle\Entity\CreditCard", mappedBy="user")
     */
    private $creditCards;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->chat = new ArrayCollection();
        $this->creditCards = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        return $this->isBot;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection
     */
    public function getChat(): Collection
    {
        return $this->chat;
    }

    /**
     * @return Collection
     */
    public function getCreditCards(): Collection
    {
        return $this->creditCards;
    }
}

