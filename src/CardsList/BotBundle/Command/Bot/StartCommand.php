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
            'text' => 'Сохраняй кредитные карты и удобно пересылай их друзьям!'.PHP_EOL.PHP_EOL.
                'Отправь мне номер карты чтобы сохрнить её.'.PHP_EOL.PHP_EOL.
                '/list - посмотреть список сохраненных карт'.PHP_EOL.PHP_EOL.
                'Чтобы быстро отправить карту с своего списка просто напиши в чате @'.$this->telegram->getBotUsername().
                ' и имя собственника карты.',
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
