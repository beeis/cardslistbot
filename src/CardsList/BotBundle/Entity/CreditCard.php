<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=160, nullable=true)
     */
    private $type;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\User", inversedBy="creditCards")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="chosen_count", type="integer", nullable=false, options={"default"=0})
     */
    private $chosenCount = 0;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * {@inheritdoc}
     */
    public function __clone()
    {
        $this->id = null;
    }

    /**
     * @return integer
     */
    public function getId()
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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
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

    /**
     * @return int
     */
    public function getChosenCount(): int
    {
        return $this->chosenCount;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    public function getLogoImage()
    {
        $logos = [
            'visaelectron' => 'https://seeklogo.com/images/V/visa_electron_new-logo-050A090FFC-seeklogo.com.png',
            'maestro' => 'https://www.about-payments.com/logo/300/225/570',
            'forbrugsforeningen' => 'http://www.wbdebtcare.com/wp-content/uploads/2016/02/credit-card.png',
            'dankort' => 'http://www.wbdebtcare.com/wp-content/uploads/2016/02/credit-card.png',
            'visa' => 'https://seeklogo.com/images/V/visa-logo-6F4057663D-seeklogo.com.png',
            'mastercard' => 'https://www.shareicon.net/data/256x256/2016/08/01/640317_card_512x512.png',
            'amex' => 'http://icons.iconarchive.com/icons/designbolts/credit-card-payment/256/American-Express-icon.png',
            'dinersclub' => 'http://www.wbdebtcare.com/wp-content/uploads/2016/02/credit-card.png',
            'discover' => 'http://www.wbdebtcare.com/wp-content/uploads/2016/02/credit-card.png',
            'unionpay' => 'http://www.wbdebtcare.com/wp-content/uploads/2016/02/credit-card.png',
            'jcb' => 'http://www.wbdebtcare.com/wp-content/uploads/2016/02/credit-card.png',
        ];

        return $logos[$this->getType()];
    }
}
