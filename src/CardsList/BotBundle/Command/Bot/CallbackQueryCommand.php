<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use CardsList\BotBundle\Entity\Card;
use CardsList\BotBundle\Entity\UserCard;
use Doctrine\ORM\EntityManagerInterface;
use Longman\TelegramBot\Request;

/**
 * Class CallbackQueryCommand
 *
 * @package CardsList\BotBundle\Command\Bot
 */
class CallbackQueryCommand extends BotCommand
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CallbackQueryCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
     * Execute command
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $callbackQuery = $this->getUpdate()->getCallbackQuery();
        $user = $callbackQuery->getFrom();
        $fullName = trim(sprintf('%s %s', $user->getFirstName(), $user->getLastName()));

        if ('addCard' === $callbackQuery->getData()) {
            //TODO: check on existing user_card row without card
            $userCard = new UserCard();
            $userCard->setUser($user->getId());
            $userCard->setCustomName($fullName);
            $userCard->setIsOwner(true);

            $this->entityManager->persist($userCard);
            $this->entityManager->flush();

            Request::sendMessage(
                [
                    'chat_id' => $callbackQuery->getMessage()->getChat()->getId(),
                    'text' => 'Отправь мне номер своей карты!',
                ]
            );
        } elseif (1 === preg_match('/addCard:([0-9]{0,20}):([0-9]{16})/', $callbackQuery->getData(), $matches)) {
            //TODO: find user by id in database
            $userId = $matches[1];
            $cardNumber = $matches[2];

            if ((int)$userId === $user->getId()) {

                return Request::answerCallbackQuery(
                    [
                        'callback_query_id' => $callbackQuery->getId(),
                        'show_alert' => true,
                        'text' => $user->getFirstName().', это действие прдназначено не для Вас.'
                    ]
                );
            }

            $card = new Card();
            $card->setUser($user->getId());
            $card->setNumber($cardNumber);

            $userCard = new UserCard();
            $userCard->setUser((int) $userId);
            $userCard->setCustomName($fullName);
            $userCard->setIsOwner(false);
            $userCard->setCard($card);

            $userCardNew = new UserCard();
            $userCardNew->setUser($user->getId());
            $userCardNew->setCustomName($fullName);
            $userCardNew->setIsOwner(true);
            $userCardNew->setCard($card);

            $this->entityManager->persist($userCardNew);
            $this->entityManager->persist($userCard);
            $this->entityManager->persist($card);
            $this->entityManager->flush();

            Request::editMessageText(
                [
                    'inline_message_id' => $callbackQuery->getInlineMessageId(),
                    'text' => $userId.' добавил карту в @'.$this->telegram->getBotUsername().PHP_EOL.
                        'Карта: '.$userCard->getCustomName().' ****'.substr($card->getNumber(), -4),
                ]
            );

        } elseif (1 === preg_match('/addCard:([0-9]{0,20})$/', $callbackQuery->getData(), $matches)) {
            $cardNumber = $matches[1];

            $card = new Card();
            $card->setUser($user->getId());
            $card->setNumber($cardNumber);

            $userCard = new UserCard();
            $userCard->setUser($user->getId());
            $userCard->setCustomName($fullName);
            $userCard->setIsOwner(true);
            $userCard->setCard($card);

            $this->entityManager->persist($userCard);
            $this->entityManager->persist($card);
            $this->entityManager->flush();

            Request::sendMessage(
                [
                    'chat_id' => $callbackQuery->getMessage()->getChat()->getId(),
                    'text' => $user->getFirstName().', я сохранил Вашу карту!'.PHP_EOL.
                        'Карта: '.$userCard->getCustomName().' ****'.substr($card->getNumber(), -4),
                ]
            );
        }

        return Request::answerCallbackQuery(
            [
                'callback_query_id' => $callbackQuery->getId(),
            ]
        );
    }
}
