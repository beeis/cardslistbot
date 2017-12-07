<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command;

use CardsList\BotBundle\Manager\TelegramManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DeleteWebhookCommand
 *
 * @package CardsList\BotBundle\Command
 */
class DeleteWebhookCommand extends Command
{
    /**
     * @var TelegramManager
     */
    private $telegramManager;

    /**
     * GetUpdatesCommand constructor.
     *
     * @param null $name
     * @param TelegramManager $telegramManager
     */
    public function __construct($name = null, TelegramManager $telegramManager)
    {
        parent::__construct($name);
        $this->telegramManager = $telegramManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('cards-list:bot:delete-webhook')
            ->setDescription('This command setup webhook');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this->telegramManager->getTelegram()->deleteWebhook();
        $output->writeln($result ?? 'Webhook deleted successfully');
    }
}
