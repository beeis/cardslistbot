<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use CardsList\BotBundle\Entity\Card;
use CardsList\BotBundle\Entity\UserCard;
use Doctrine\ORM\EntityManagerInterface;
use Longman\TelegramBot\Request;

/**
 * Class ChosenInlineResultCommand
 *
 * @package CardsList\BotBundle\Command\Bot
 */
class ChosenInlineResultCommand extends BotCommand
{
    /**
     * @var string
     */
    protected $name = 'choseninlineresult';

    /**
     * @var string
     */
    protected $description = 'ChosenInlineResultCommand';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * MessageCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        return Request::emptyResponse();
    }
}
