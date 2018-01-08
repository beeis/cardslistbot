<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Controller;

use CardsList\BotBundle\Manager\TelegramManager;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DefaultController
 *
 * @package CardsList\BotBundle\Controller
 */
class WebhookController extends Controller
{
    /**
     * @var TelegramManager
     */
    private $telegramManager;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->telegramManager = $container->get('cards_list_bot.manager.telegram_manager');
    }

    public function indexAction()
    {
        try {
            $this->telegramManager->getTelegram()->handle();
        } catch (TelegramException $exception) {
            new ServerResponse(['ok' => false, 'result' => false], null);
        }

        return new JsonResponse(['ok' => false, 'result' => false]);
    }
}
