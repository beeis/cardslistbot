<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Component;

use CardsList\BotBundle\Command\Bot\BotCommand;
use Longman\TelegramBot\Exception\TelegramException;
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
     *
     * @return BotCommand
     */
    public function getCommandObject($command)
    {
        $command = explode('_', $command);

        if (false === isset($this->commands[$command['0']])) {
            throw new TelegramException(sprintf('Command %s is not valid', $command['0']));
        }

        $commandObject = $this->commands[$command['0']];
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
