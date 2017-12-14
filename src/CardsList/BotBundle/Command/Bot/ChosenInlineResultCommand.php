<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use CardsList\BotBundle\Manager\CreditCardManager;
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
     * @var CreditCardManager
     */
    private $creditCardManager;

    /**
     * MessageCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param CreditCardManager $creditCardManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        CreditCardManager $creditCardManager
    ) {
        $this->entityManager = $entityManager;
        $this->creditCardManager = $creditCardManager;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $chosenInline = $this->getUpdate()->getChosenInlineResult();
        $this->creditCardManager->chosen($chosenInline->getResultId());

        return Request::emptyResponse();
    }
}
