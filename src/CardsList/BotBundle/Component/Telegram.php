<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Component;

use CardsList\BotBundle\Command\Bot\BotCommand;
use Longman\TelegramBot\Telegram as CoreTelegram;

/**
 * Class Telegram
 *
 * @package CardsList\BotBundle\Component
 */
class Telegram extends CoreTelegram
{
    /**
     * @var array|BotCommand[]
     */
    private $commands = [];

    /**
     * @param string $commandName
     * @param BotCommand $command
     */
    public function addCommand(string $commandName, BotCommand $command)
    {
        $command->setTelegram($this);
        $this->commands[$commandName] = $command;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommandsList()
    {
        return $this->commands;
    }

    /**
     * {@inheritdoc}
     * @deprecated
     *
     * @return BotCommand
     */
    public function getCommandObject($command)
    {
        $commandObject = $this->commands[$command];
        $commandObject->setUpdate($this->update);

        return $commandObject;
    }

    /**
     * {@inheritdoc}
     * @deprecated
     */
    public function getCommandsPaths()
    {
    }

    /**
     * {@inheritdoc}
     * @deprecated
     */
    public function addCommandsPath($path, $before = true)
    {
    }
}
