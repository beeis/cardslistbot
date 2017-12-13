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
        $this->creditCardManager->delete($data['card_id']);

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

        $conversation = new Conversation($callbackQuery->getFrom()->getId(), $callbackQuery->getMessage()->getChat()->getId(), 'edit');
        $conversation->notes = ['card_id' => $creditCard->getId()];
        $conversation->update();

        Request::sendMessage(
            [
                'chat_id' => $callbackQuery->getMessage()->getChat()->getId(),
                'text' => 'Для окончания процесса редактирования карты напишите новое имя владельца:',
            ]
        );

        return Request::answerCallbackQuery(
            [
                'callback_query_id' => $callbackQuery->getId()
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
