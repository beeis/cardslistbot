<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use CardsList\BotBundle\Manager\CreditCardManager;
use Longman\TelegramBot\Request;

/**
 * Class CardCommand
 *
 * @package CardsList\BotBundle\Command\Bot
 */
class CardCommand extends BotCommand
{
    const NAME = 'card';

    /**
     * Name
     *
     * @var string
     */
    protected $name = 'card';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'More user card';

    /**
     * Usage
     *
     * @var string
     */
    protected $usage = '/card_(user_card_id)';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var CreditCardManager
     */
    private $creditCardManager;

    /**
     * ListCommand constructor.
     *
     * @param CreditCardManager $creditCardManager
     */
    public function __construct(CreditCardManager $creditCardManager)
    {
        $this->creditCardManager = $creditCardManager;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();
        $data = ['chat_id' => $message->getChat()->getId(),];

        $command = explode('_', $message->getCommand());
        if (false === isset($command[1])) {
            $data['text'] = 'Не правильный формат команди /'.self::NAME;

            return Request::sendMessage($data);
        }

        $creditCard = $this->creditCardManager->findCard($command[1]);
        if (null === $creditCard) {
            $data['text'] = 'Такая карта не существует, команду из списка /'.ListCommand::NAME;

            return Request::sendMessage($data);
        }

        $data = [
            'chat_id' => $message->getChat()->getId(),
            'text' => sprintf(
                '👤 %s '.PHP_EOL.'💳 %s',
                $creditCard->getHolderName(),
                $creditCard->getNumber()
            ),
            'reply_markup' => [
                'inline_keyboard' => [
                    [
                        [
                            'text' => '🗣',
                            'switch_inline_query' => $creditCard->getNumber(),
                        ],
                        [
                            'text' => '✏️',
                            'callback_data' => json_encode(
                                [
                                    'command' => 'edit',
                                    'card_id' => $creditCard->getId(),
                                ]
                            ),
                        ],
                        [
                            'text' => '❌',
                            'callback_data' => json_encode(
                                [
                                    'command' => 'delete',
                                    'card_id' => $creditCard->getId(),
                                ]
                            ),
                        ],
                    ],
                ],
            ],
        ];

        return Request::sendMessage($data);
    }
}
