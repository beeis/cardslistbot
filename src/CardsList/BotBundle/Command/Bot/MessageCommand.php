<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use CardsList\BotBundle\Entity\CreditCard;
use CardsList\BotBundle\Entity\User;
use CardsList\BotBundle\Manager\CreditCardManager;
use Inacho\CreditCard as InachoCreditCard;
use Doctrine\ORM\EntityManagerInterface;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Request;

/**
 * Class MessageCommand
 *
 * @package CardsList\BotBundle\Command\Bot
 */
class MessageCommand extends BotCommand
{
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
    )
    {
        $this->entityManager = $entityManager;
        $this->creditCardManager = $creditCardManager;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();
        $user = $message->getFrom();
        $chat_id = $message->getChat()->getId();

        $conversation = new Conversation($user->getId(), $chat_id);
        if (true === $conversation->exists()) {
            $holderName = $message->getText();

            if ('add' === $conversation->getCommand()) {
                $userEntity = $this->entityManager->find(User::class, $user->getId());
                $creditCard = new CreditCard();
                $creditCard->setNumber($conversation->notes['number']);
                $creditCard->setType($conversation->notes['type']);
                $creditCard->setUser($userEntity);

                $messageText = 'Я успешно сохранил карту в Ваш список.';
            } else {
                $creditCard = $this->creditCardManager->findCard($conversation->notes['card_id']);
                if (null === $creditCard) {
                    return Request::sendMessage(
                        [
                            'chat_id' => $chat_id,
                            'text' => 'Простите, но карта небыла найдена :(',
                        ]
                    );
                }

                $messageText = 'Я успешно отредактировал Вашу карту.';
            }

            $creditCard->setHolderName(trim($holderName));

            $this->entityManager->persist($creditCard);
            $this->entityManager->flush();

            $conversation->stop();

            return Request::sendMessage(
                [
                    'chat_id' => $chat_id,
                    'text' => $messageText.PHP_EOL.
                        '/list - посмотреть весь список'.PHP_EOL.PHP_EOL.
                        sprintf(
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
                ]
            );
        }

        $cardValid = InachoCreditCard::validCreditCard($message->getText());
        if (false === $cardValid['valid']) {
            return Request::sendMessage(
                [
                    'chat_id' => $chat_id,
                    'text' => 'Простите, но "'.$message->getText().'" неверное значение карты'.PHP_EOL.
                        'Повторите попытку!',
                ]
            );
        }

        /** @var CreditCard $creditCard */
        $creditCard = $this->entityManager->createQueryBuilder()
            ->select('credit_card')
            ->from('CardsListBotBundle:CreditCard', 'credit_card')
            ->where('credit_card.number = :number')
            ->andWhere('credit_card.user = :user_id')
            ->setParameters(
                [
                    'number' => $cardValid['number'],
                    'user_id' => $user->getId(),
                ]
            )
            ->getQuery()
            ->getOneOrNullResult();

        if (null !== $creditCard) {
            return Request::sendMessage(
                [
                    'chat_id' => $chat_id,
                    'text' => 'Такая карта уже существует'.PHP_EOL.PHP_EOL.
                        sprintf(
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
                ]
            );
        }

        $conversation = new Conversation($user->getId(), $chat_id, 'add');
        $conversation->notes = [
            'number' => $cardValid['number'],
            'type' => $cardValid['type'],
        ];
        $conversation->update();

        return Request::sendMessage(
            [
                'chat_id' => $chat_id,
                'text' => 'Напишите имя собственика карты чтобы закончить процесс сохранения карты!',
            ]
        );
    }
}
