<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

/**
 * Class StartCommand
 *
 * @package CardsList\BotBundle\Command\Bot
 */
class StartCommand extends BotCommand
{
    /**
     * Name
     *
     * @var string
     */
    protected $name = 'start';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Usage
     *
     * @var string
     */
    protected $usage = 'Command usage';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Execute command
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        $data = [
            'chat_id' => $chat_id,
            'text' => 'Я бот для сохранения номеров кредитных карт!'.PHP_EOL.PHP_EOL.
                'С помощью этого бота можно сохранять номера кредитных карт своих друзей'.
                'и отправлять свой номер карты друзьям.'.PHP_EOL.PHP_EOL.
                'Для того чтобы отправить номер карты своему другу наберите @'.$this->telegram->getBotUsername().
                ' и выберете свою карту!',
            'reply_markup' => [
                'inline_keyboard' => [
                    [
                        [
                            'text' => '➕ Карту',
                            'callback_data' => 'addCard',
                        ],
                        [
                            'text' => '➕ Друга',
                            'switch_inline_query' => 'method:addCard',
                        ],
                    ],
                ],
            ],
        ];

        return Request::sendMessage($data);
    }
}
