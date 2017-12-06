<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Telegram;

/**
 * Class BotCommand
 *
 * @package CardsList\BotBundle\Command\Bot
 */
abstract class BotCommand extends Command
{
    public function __construct()
    {
    }

    /**
     * @param Telegram $telegram
     */
    public function setTelegram(Telegram $telegram)
    {
        $this->telegram = $telegram;
    }
}
