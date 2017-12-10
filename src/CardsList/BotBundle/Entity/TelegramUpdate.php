<?php

namespace CardsList\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TelegramUpdate
 *
 * @ORM\Table(
 *     name="telegram_update",
 *     indexes={
 *          @ORM\Index(name="message_id", columns={"chat_id", "message_id"}),
 *          @ORM\Index(name="inline_query_id", columns={"inline_query_id"}),
 *          @ORM\Index(name="chosen_inline_result_id", columns={"chosen_inline_result_id"}),
 *          @ORM\Index(name="callback_query_id", columns={"callback_query_id"}),
 *          @ORM\Index(name="edited_message_id", columns={"edited_message_id"})
 *      },
 *     options={"collate"="utf8mb4_unicode_520_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class TelegramUpdate
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
     * @var \CardsList\BotBundle\Entity\Message
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\Message")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chat_id", referencedColumnName="chat_id"),
     *   @ORM\JoinColumn(name="message_id", referencedColumnName="id")
     * })
     */
    private $chat;

    /**
     * @var \CardsList\BotBundle\Entity\InlineQuery
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\InlineQuery")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inline_query_id", referencedColumnName="id")
     * })
     */
    private $inlineQuery;

    /**
     * @var \CardsList\BotBundle\Entity\ChosenInlineResult
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\ChosenInlineResult")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chosen_inline_result_id", referencedColumnName="id")
     * })
     */
    private $chosenInlineResult;

    /**
     * @var \CardsList\BotBundle\Entity\CallbackQuery
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\CallbackQuery")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="callback_query_id", referencedColumnName="id")
     * })
     */
    private $callbackQuery;

    /**
     * @var \CardsList\BotBundle\Entity\EditedMessage
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\EditedMessage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="edited_message_id", referencedColumnName="id")
     * })
     */
    private $editedMessage;


}

