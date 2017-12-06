<?php

namespace CardsList\BotBundle\Entity;

/**
 * UserCard
 */
class UserCard
{
    /**
     * @var int Telegram user id
     */
    private $id;

    /**
     * @var integer
     */
    private $user;

    /**
     * @var Card|null
     */
    private $card;

    /**
     * @var string
     */
    private $customName;

    /**
     * @var bool
     */
    private $isOwner = false;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Card|null
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param Card|null $card
     */
    public function setCard($card)
    {
        $this->card = $card;
    }

    /**
     * @return string
     */
    public function getCustomName(): string
    {
        return $this->customName;
    }

    /**
     * @param string $customName
     */
    public function setCustomName(string $customName)
    {
        $this->customName = $customName;
    }

    /**
     * @return bool
     */
    public function isOwner(): bool
    {
        return $this->isOwner;
    }

    /**
     * @param bool $isOwner
     */
    public function setIsOwner(bool $isOwner)
    {
        $this->isOwner = $isOwner;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser(int $user)
    {
        $this->user = $user;
    }
}

