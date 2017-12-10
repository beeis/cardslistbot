<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use CardsList\BotBundle\Entity\Card;
use CardsList\BotBundle\Entity\UserCard;
use Doctrine\ORM\EntityManagerInterface;
use Inacho\CreditCard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
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
     * MessageCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Execute command
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute()
    {
        $message = $this->getMessage();
        $user = $message->getFrom();
        $chat_id = $message->getChat()->getId();

        /*$userCardRepository = $this->entityManager->getRepository(UserCard::class);
        $userCard = $userCardRepository->findOneBy(
            [
                'user' => $user->getId(),
                'card' => null,
            ]
        );

        $cardValid = CreditCard::validCreditCard($message->getText());
        if (false === $cardValid['valid']) {
            return Request::sendMessage(
                [
                    'chat_id' => $chat_id,
                    'text' => 'Простите, но '.$message->getText().' неверное значение карты'.PHP_EOL.
                        'Повторите попытку!',
                ]
            );
        }

        if (null === $userCard) {*/
            //TODO: check on existing card number
            return Request::sendMessage(
                [
                    'chat_id' => $chat_id,
                    'text' => 'Хотите добавить эту карту `'.$message->getText().'`?',
                    'reply_markup' => [
                        'inline_keyboard' => [
                            [
                                [
                                    'text' => '➕ Карту',
                                    'callback_data' => 'addCard:',
                                ],
                                [
                                    'text' => '➕ Друга',
                                    'switch_inline_query' => 'method:addCard:',
                                ],
                            ],
                        ],
                    ],
                ]
            );
       /* }

        $card = new Card();
        $card->setUser($user->getId());
        $card->setNumber($cardValid['number']);
        $userCard->setCard($card);
        //TODO: set card type

        $this->entityManager->persist($card);
        $this->entityManager->persist($userCard);
        $this->entityManager->flush();

        return Request::sendMessage(
            [
                'chat_id' => $chat_id,
                'text' => $user->getFirstName().', я сохранил Вашу карту!'.PHP_EOL.
                    'Карта: '.$userCard->getCustomName().' ****'.substr($card->getNumber(), -4),
            ]
        );*/
    }
}
