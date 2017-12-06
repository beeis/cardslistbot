<?php

namespace CardsList\BotBundle\Command;

use CardsList\BotBundle\Manager\TelegramManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GetUpdatesCommand
 *
 * @package AppBundle\Command
 */
class GetUpdatesCommand extends Command
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
            ->setName('cards-lis:bot:get-updates')
            ->setDescription('This command activate Telegram getUpdates');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->telegramManager->getTelegram()->handleGetUpdates();
        print_r($response->getResult());

        $output->writeln('hello world!');
    }
}
