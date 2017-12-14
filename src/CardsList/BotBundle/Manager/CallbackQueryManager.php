<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Manager;

use CardsList\BotBundle\Entity\User;
use CardsList\BotBundle\Exception\CardsListBotException;
use Doctrine\ORM\EntityManagerInterface;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

/**
 * Class CallbackQueryManager
 *
 * @package CardsList\BotBundle\Manager
 */
class CallbackQueryManager
{
    /**
     * @var CreditCardManager
     */
    private $creditCardManager;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CallbackQueryManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param CreditCardManager $creditCardManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        CreditCardManager $creditCardManager
    ) {
        $this->creditCardManager = $creditCardManager;
        $this->entityManager = $entityManager;
    }

    /**
     * @param CallbackQuery $callbackQuery
     *
     * @return ServerResponse
     * @throws CardsListBotException
     */
    public function cloneToUser(CallbackQuery $callbackQuery): ServerResponse
    {
        $data = json_decode($callbackQuery->getData(), true);
        $telegramUser = $callbackQuery->getFrom();
        $user = $this->findUser($telegramUser->getId());

        $this->creditCardManager->cloneToUser($data['card_id'], $user);

        return Request::answerCallbackQuery(
            [
                'callback_query_id' => $callbackQuery->getId(),
                'text' => 'Карта успешно сохранена',
            ]
        );
    }

    /**
     * @param CallbackQuery $callbackQuery
     *
     * @return ServerResponse
     */
    public function delete(CallbackQuery $callbackQuery): ServerResponse
    {
        $data = json_decode($callbackQuery->getData(), true);
        $creditCard = $this->creditCardManager->findCard($data['card_id']);
        if (null === $creditCard) {
            return Request::answerCallbackQuery(
                [
                    'callback_query_id' => $callbackQuery->getId(),
                    'text' => '😞 Карта не найдена',
                ]
            );
        }

        //stops editing conversation of current credit card
        $conversation = new Conversation(
            $callbackQuery->getFrom()->getId(),
            $callbackQuery->getMessage()->getChat()->getId()
        );

        if (true === $conversation->exists() && 'edit' === $conversation->getCommand()) {
            Request::deleteMessage(
                [
                    'chat_id' => $conversation->notes['chat_id'],
                    'message_id' => $conversation->notes['message_id'],
                ]
            );
            $conversation->stop();
        }

        //delete card by id
        $this->creditCardManager->delete($data['card_id']);

        Request::editMessageText(
            [
                'chat_id' => $callbackQuery->getMessage()->getChat()->getId(),
                'message_id' => $callbackQuery->getMessage()->getMessageId(),
                'text' => sprintf(
                    'Карта удалена: 👤 %s 💳 ****%s'.PHP_EOL.
                    '➡️ Чтобы добавить новую карту - просто отправьте мне её номер.',
                    $creditCard->getHolderName(),
                    substr($creditCard->getNumber(), -4)
                ),
            ]
        );

        return Request::answerCallbackQuery(
            [
                'callback_query_id' => $callbackQuery->getId(),
                'text' => '👍 Карта успешно удалена',
            ]
        );
    }

    /**
     * @param CallbackQuery $callbackQuery
     *
     * @return ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function edit(CallbackQuery $callbackQuery): ServerResponse
    {
        $data = json_decode($callbackQuery->getData(), true);
        $creditCard = $this->creditCardManager->findCard($data['card_id']);
        if (null === $creditCard) {
            return Request::answerCallbackQuery(
                [
                    'callback_query_id' => $callbackQuery->getId(),
                    'text' => '😞 Карта не была найдена',
                ]
            );
        }

        $conversation = new Conversation(
            $callbackQuery->getFrom()->getId(),
            $callbackQuery->getMessage()->getChat()->getId(),
            'edit'
        );

        $messageResponse = Request::sendMessage(
            [
                'chat_id' => $callbackQuery->getMessage()->getChat()->getId(),
                'text' => 'Напишите новое имя владельца карты:',
            ]
        );

        $conversation->notes = [
            'card_id' => $creditCard->getId(),
            'message_id' => $messageResponse->getResult()->getMessageId(),
            'chat_id' => $messageResponse->getResult()->getChat()->getId(),
        ];
        $conversation->update();

        return Request::answerCallbackQuery(
            [
                'callback_query_id' => $callbackQuery->getId(),
            ]
        );
    }

    /**
     * @param $id
     *
     * @return User|object
     */
    private function findUser($id)
    {
        return $this->entityManager->find(User::class, $id);
    }
}
