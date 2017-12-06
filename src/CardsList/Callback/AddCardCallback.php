<?php

declare(strict_types=1);

namespace CardsList\Callback;

use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Request;

/**
 * Class AddCardCallback
 *
 * @package CardsList\Callback
 */
class AddCardCallback implements CoreCallback
{
    const CALLBACK_DATA = 'addCard';

    /**
     * {@inheritdoc}
     */
    public function execute(CallbackQuery $callbackQuery)
    {
        //TODO: create item, waiting for card

        Request::sendMessage(
            [
                'chat_id' => $callbackQuery->getMessage()->getChat()->getId(),
                'text' => 'Отправь мне номер своей карты!',
            ]
        );
    }
}
