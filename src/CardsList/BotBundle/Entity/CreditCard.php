<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CreditCard
 *
 * @package CardsList\BotBundle\Entity
 *
 * @ORM\Table(
 *     name="credit_card",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="idx_card", columns={"number", "user_id"})},
 *     options={"collate"="utf8mb4_unicode_520_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class CreditCard
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=160, nullable=true)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="holder_name", type="string", length=160, nullable=true)
     */
    private $holderName;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="smallint", length=1, nullable=true)
     */
    private $type;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getHolderName(): string
    {
        return $this->holderName;
    }

    /**
     * @param string $holderName
     */
    public function setHolderName(string $holderName): void
    {
        $this->holderName = $holderName;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
