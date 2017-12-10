<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Manager;

use CardsList\BotBundle\Component\Telegram;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\PDOConnection;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\TelegramLog;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class TelegramManager
 *
 * @package CardsList\BotBundle\Manager
 */
class TelegramManager
{
    /**
     * @var Telegram
     */
    private $telegram;

    /**
     * @var Connection|PDOConnection
     */
    private $connection;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var null|string
     */
    private $webhookUrl;

    /**
     * TelegramManager constructor.
     *
     * @param Telegram $telegram
     * @param Connection|PDOConnection $connection
     * @param Logger $logger
     * @param ContainerInterface $container
     * @param array $data
     */
    public function __construct(
        Telegram $telegram,
        Connection $connection,
        Logger $logger,
        ContainerInterface $container,
        array $data = null
    ) {
        $this->telegram = $telegram;
        $this->connection = $connection;
        $this->container = $container;
        $this->logger = $logger;
        $this->webhookUrl = $data['webhook_url'] ?? null;
        $this->init($data);
    }

    protected function init($data)
    {
        $this->enableMySqlConnection();
        $this->enableLogging();

        if (true === isset($data['botan_url'])) {
            $this->telegram->enableBotan($data['botan_url']);
        }
    }

    private function enableMySqlConnection()
    {
        $this->telegram->enableExternalMySql($this->connection);
    }

    private function enableLogging()
    {
        TelegramLog::initErrorLog($this->container->getParameter('kernel.logs_dir').'_error.log');
        TelegramLog::initDebugLog($this->container->getParameter('kernel.logs_dir').'_error.log');
        TelegramLog::initUpdateLog($this->container->getParameter('kernel.logs_dir').'_error.log');

        TelegramLog::initialize($this->logger);
    }

    /**
     * @return Telegram
     */
    public function getTelegram(): Telegram
    {
        return $this->telegram;
    }

    /**
     * @return string|null
     */
    public function setupWebhook()
    {
        try {
            $this->telegram->setWebhook($this->webhookUrl);
        } catch (TelegramException $exception) {
            return $exception->getMessage();
        }

        return null;
    }

}
