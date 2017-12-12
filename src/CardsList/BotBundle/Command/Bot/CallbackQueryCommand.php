<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use CardsList\BotBundle\Exception\CardsListBotException;
use CardsList\BotBundle\Manager\CallbackQueryManager;
use Doctrine\ORM\EntityManagerInterface;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

/**
 * Class CallbackQueryCommand
 *
 * @package CardsList\BotBundle\Command\Bot
 */
class CallbackQueryCommand extends BotCommand
{
    /**
     * Name
     *
     * @var string
     */
    protected $name = 'callbackquery';

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
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CallbackQueryManager
     */
    private $callbackQueryManager;

    /**
     * CallbackQueryCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param CallbackQueryManager $callbackQueryManager
     */
    public function __construct(EntityManagerInterface $entityManager, CallbackQueryManager $callbackQueryManager)
    {
        $this->entityManager = $entityManager;
        $this->callbackQueryManager = $callbackQueryManager;
    }

    /**
     * Execute command
     *
     * @return ServerResponse
     */
    public function execute()
    {
        $callbackQuery = $this->getUpdate()->getCallbackQuery();
        $data = json_decode($callbackQuery->getData(), true);

        try {
            $command = $data['command'];
            return $this->callbackQueryManager->$command($callbackQuery);
        } catch (CardsListBotException $exception) {
            return Request::answerCallbackQuery(
                [
                    'callback_query_id' => $callbackQuery->getId(),
                    'text' => $exception->getMessage(),
                ]
            );
        } catch (\Exception $exception) {
            return Request::answerCallbackQuery(
                [
                    'callback_query_id' => $callbackQuery->getId(),
                    'text' => $exception->getMessage(),
                ]
            );
        }
    }
}
