<?php

namespace CardsList\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BotanShortener
 *
 * @ORM\Table(
 *     name="botan_shortener",
 *     indexes={@ORM\Index(name="user_id", columns={"user_id"})},
 *     options={"collate"="utf8mb4_unicode_520_ci", "charset"="utf8mb4"}
 *     )
 * @ORM\Entity
 */
class BotanShortener
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
     * @ORM\Column(name="url", type="text", length=65535, nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="short_url", type="string", length=255, nullable=false, options={"fixed" = true})
     */
    private $shortUrl = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \CardsList\BotBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}

