<?php

namespace CardsList\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EditedMessage
 *
 * @ORM\Table(
 *     name="edited_message",
 *     indexes={
 *      @ORM\Index(name="message_id", columns={"message_id"}),
 *      @ORM\Index(name="user_id", columns={"user_id"}),
 *      @ORM\Index(name="chat_id_2", columns={"chat_id", "message_id"}),
 *      @ORM\Index(name="IDX_7D194E541A9A7125", columns={"chat_id"})
 *     },
 *     options={"collate"="utf8mb4_unicode_520_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class EditedMessage
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
     * @var integer
     *
     * @ORM\Column(name="message_id", type="bigint", nullable=true)
     */
    private $messageId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="edit_date", type="datetime", nullable=true)
     */
    private $editDate;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", length=65535, nullable=true)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="entities", type="text", length=65535, nullable=true)
     */
    private $entities;

    /**
     * @var string
     *
     * @ORM\Column(name="caption", type="text", length=65535, nullable=true)
     */
    private $caption;

    /**
     * @var \CardsList\BotBundle\Entity\Chat
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\Chat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chat_id", referencedColumnName="id")
     * })
     */
    private $chat;

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

