<?php

namespace CardsList\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(
 *     name="message",
 *     indexes={
 *         @ORM\Index(name="user_id", columns={"user_id"}),
 *         @ORM\Index(name="forward_from", columns={"forward_from"}),
 *         @ORM\Index(name="forward_from_chat", columns={"forward_from_chat"}),
 *         @ORM\Index(name="reply_to_chat", columns={"reply_to_chat"}),
 *         @ORM\Index(name="reply_to_message", columns={"reply_to_message"}),
 *         @ORM\Index(name="left_chat_member", columns={"left_chat_member"}),
 *         @ORM\Index(name="migrate_from_chat_id", columns={"migrate_from_chat_id"}),
 *         @ORM\Index(name="migrate_to_chat_id", columns={"migrate_to_chat_id"}),
 *         @ORM\Index(name="reply_to_chat_2", columns={"reply_to_chat", "reply_to_message"})
 *     },
 *     options={"collate"="utf8mb4_unicode_520_ci", "charset"="utf8mb4"}
 * )
 * @ORM\Entity
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", length=20, options={"unsigned"=true, "comment" = "Unique message identifier"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="forward_from_message_id", type="bigint", nullable=true)
     */
    private $forwardFromMessageId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="forward_date", type="datetime", nullable=true)
     */
    private $forwardDate;

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
     * @ORM\Column(name="audio", type="text", length=65535, nullable=true)
     */
    private $audio;

    /**
     * @var string
     *
     * @ORM\Column(name="document", type="text", length=65535, nullable=true)
     */
    private $document;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="text", length=65535, nullable=true)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="sticker", type="text", length=65535, nullable=true)
     */
    private $sticker;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="text", length=65535, nullable=true)
     */
    private $video;

    /**
     * @var string
     *
     * @ORM\Column(name="voice", type="text", length=65535, nullable=true)
     */
    private $voice;

    /**
     * @var string
     *
     * @ORM\Column(name="video_note", type="text", length=65535, nullable=true)
     */
    private $videoNote;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="text", length=65535, nullable=true)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="text", length=65535, nullable=true)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="venue", type="text", length=65535, nullable=true)
     */
    private $venue;

    /**
     * @var string
     *
     * @ORM\Column(name="caption", type="text", length=65535, nullable=true)
     */
    private $caption;

    /**
     * @var string
     *
     * @ORM\Column(name="new_chat_members", type="text", length=65535, nullable=true)
     */
    private $newChatMembers;

    /**
     * @var string
     *
     * @ORM\Column(name="new_chat_title", type="string", length=255, nullable=true, options={"fixed" = true})
     */
    private $newChatTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="new_chat_photo", type="text", length=65535, nullable=true)
     */
    private $newChatPhoto;

    /**
     * @var boolean
     *
     * @ORM\Column(name="delete_chat_photo", type="boolean", nullable=true)
     */
    private $deleteChatPhoto = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="group_chat_created", type="boolean", nullable=true)
     */
    private $groupChatCreated = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="supergroup_chat_created", type="boolean", nullable=true)
     */
    private $supergroupChatCreated = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="channel_chat_created", type="boolean", nullable=true)
     */
    private $channelChatCreated = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="migrate_to_chat_id", type="bigint", nullable=true)
     */
    private $migrateToChatId;

    /**
     * @var integer
     *
     * @ORM\Column(name="migrate_from_chat_id", type="bigint", nullable=true)
     */
    private $migrateFromChatId;

    /**
     * @var string
     *
     * @ORM\Column(name="pinned_message", type="text", length=65535, nullable=true)
     */
    private $pinnedMessage;

    /**
     * @var \CardsList\BotBundle\Entity\Chat
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="CardsList\BotBundle\Entity\Chat")
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

    /**
     * @var \CardsList\BotBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="forward_from", referencedColumnName="id")
     * })
     */
    private $forwardFrom;

    /**
     * @var \CardsList\BotBundle\Entity\Chat
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\Chat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="forward_from_chat", referencedColumnName="id")
     * })
     */
    private $forwardFromChat;

    /**
     * @var \CardsList\BotBundle\Entity\Message
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\Message")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reply_to_chat", referencedColumnName="chat_id"),
     *   @ORM\JoinColumn(name="reply_to_message", referencedColumnName="id")
     * })
     */
    private $replyToChat;

    /**
     * @var \CardsList\BotBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="left_chat_member", referencedColumnName="id")
     * })
     */
    private $leftChatMember;


}

