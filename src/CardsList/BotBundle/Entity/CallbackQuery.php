<?php

namespace CardsList\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CallbackQuery
 *
 * @ORM\Table(
 *     name="callback_query",
 *     indexes={
 *      @ORM\Index(name="user_id", columns={"user_id"}),
 *      @ORM\Index(name="chat_id", columns={"chat_id"}),
 *      @ORM\Index(name="message_id", columns={"message_id"}),
 *      @ORM\Index(name="chat_id_2", columns={"chat_id", "message_id"})
 *     },
 *     options={"collate"="utf8mb4_unicode_520_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class CallbackQuery
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="inline_message_id", type="string", length=255, nullable=true)
     */
    private $inlineMessageId;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="string", length=255, nullable=false)
     */
    private $data = '';

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

    /**
     * @var \CardsList\BotBundle\Entity\Message
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\Message")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chat_id", referencedColumnName="chat_id"),
     *   @ORM\JoinColumn(name="message_id", referencedColumnName="id")
     * })
     */
    private $chat;


}

