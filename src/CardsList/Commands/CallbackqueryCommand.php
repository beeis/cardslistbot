<?php

declare(strict_types=1);

namespace Longman\TelegramBot\Commands\SystemCommands;

use CardsList\Callback\AddCardCallback;
use CardsList\Callback\CoreCallback;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

/**
 * Callback query command
 */
class CallbackqueryCommand extends SystemCommand
{
    /**
     * @var callable[]
     */
    protected static $callbacks = [
        AddCardCallback::CALLBACK_DATA => AddCardCallback::class,
    ];

    /**
     * @var string
     */
    protected $name = 'callbackquery';

    /**
     * @var string
     */
    protected $description = 'Reply to callback query';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Command execute method
     *
     * @return mixed
     * @throws TelegramException
     */
    public function execute()
    {
        $callbackQuery = $this->getUpdate()->getCallbackQuery();

        /** @var CoreCallback $callback */
        $callback = new self::$callbacks[$callbackQuery->getData()];
        $callback->execute($callbackQuery);

        return Request::answerCallbackQuery(
            [
                'callback_query_id' => $callbackQuery->getId(),
            ]
        );
    }
}
