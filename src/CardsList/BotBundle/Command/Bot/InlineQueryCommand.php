<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use Doctrine\ORM\EntityManagerInterface;
use Longman\TelegramBot\Request;

/**
 * Class InlineQueryCommand
 *
 * @package CardsList\BotBundle\Command\Bot
 */
class InlineQueryCommand extends BotCommand
{
    /**
     * @var string
     */
    protected $name = 'inlinequery';

    /**
     * @var string
     */
    protected $description = 'Reply to inline query';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CallbackQueryCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $inline_query = $this->getUpdate()->getInlineQuery();
        $user_id = $inline_query->getFrom();
        $query = $inline_query->getQuery();

        if (1 === preg_match('/method:addCard:[0-9]{16}/', $query)) {
            //TODO: check is number valid

            return Request::answerInlineQuery(
                [
                    'inline_query_id' => $this->getUpdate()->getInlineQuery()->getId(),
                    'cache_time' => 0, //for dev env
                    'results' => [
                        [
                            'type' => 'article',
                            'id' => substr($query, -16),
                            'title' => 'Отправить другу запрос на добавление карти',
                            'input_message_content' => [
                                'message_text' => $inline_query->getFrom()->getFirstName().
                                    ' хочет добавить вашу карту '.
                                    substr($query, -16).
                                    ' в список @'.$this->telegram->getBotUsername(),
                            ],
                            'reply_markup' => [
                                'inline_keyboard' => [
                                    [
                                        [
                                            'text' => '➕ Добавть',
                                            'callback_data' => 'addCard:'.$inline_query->getFrom()->getId().':'.
                                                substr($query, -16),
                                        ],
                                    ],
                                ],
                            ],
                            'thumb_url' => 'https://vignette.wikia.nocookie.net/creditcards/images/6/65/Brand.gif/revision/latest',
                            'thumb_width' => 50,
                            'thumb_height' => 50,
                        ],
                    ],
                ]
            );
        } elseif (1 === preg_match('/method:addCard$/', $query)) {

            return Request::answerInlineQuery(
                [
                    'inline_query_id' => $this->getUpdate()->getInlineQuery()->getId(),
                    'cache_time' => 0, //for dev env
                    'results' => [
                        [
                            'type' => 'article',
                            'id' => substr($query, -16),
                            'title' => 'Отправить другу запрос на добавление',
                            'input_message_content' => [
                                'message_text' => $inline_query->getFrom()->getFirstName().
                                    ' запрашивает Вашу кредитную карту чтобы сохранить её'.
                                    ' в список @'.$this->telegram->getBotUsername().PHP_EOL.PHP_EOL.
                                    'Перейдите в бота чтобы добавить свою карту @'.$this->telegram->getBotUsername(),
                            ],
                            'thumb_url' => 'https://vignette.wikia.nocookie.net/creditcards/images/6/65/Brand.gif/revision/latest',
                            'thumb_width' => 50,
                            'thumb_height' => 50,
                        ],
                    ],
                ]
            );
        }

        return Request::answerInlineQuery(
            [
                'inline_query_id' => $this->getUpdate()->getInlineQuery()->getId(),
            ]
        );
    }
}
