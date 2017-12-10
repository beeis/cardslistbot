<?php

namespace CardsList\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequestLimiter
 *
 * @ORM\Table(
 *     name="request_limiter",
 *     options={"collate"="utf8mb4_unicode_520_ci", "charset"="utf8mb4"}))
 * @ORM\Entity
 */
class RequestLimiter
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
     * @ORM\Column(name="chat_id", type="string", length=255, nullable=true, options={"fixed" = true})
     */
    private $chatId;

    /**
     * @var string
     *
     * @ORM\Column(name="inline_message_id", type="string", length=255, nullable=true, options={"fixed" = true})
     */
    private $inlineMessageId;

    /**
     * @var string
     *
     * @ORM\Column(name="method", type="string", length=255, nullable=true, options={"fixed" = true})
     */
    private $method;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;


}

