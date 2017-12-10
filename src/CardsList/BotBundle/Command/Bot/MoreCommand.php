<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use CardsList\BotBundle\Entity\UserCard;
use Doctrine\ORM\EntityManagerInterface;
use Longman\TelegramBot\Request;

/**
 * Class MoreCommand
 *
 * @package CardsList\BotBundle\Command\Bot
 */
class MoreCommand extends BotCommand
{
    const NAME = 'card';

    /**
     * Name
     *
     * @var string
     */
    protected $name = 'more';

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
    protected $usage = '/more_(user_card_id)';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ListCommand constructor.
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
        $message = $this->getMessage();
        $data = ['chat_id' => $message->getChat()->getId(),];

        $command = explode('_', $message->getCommand());
        if (false === isset($command[1])) {
            $data['text'] = 'Не правильный формат команди /more';

            return Request::sendMessage($data);
        }

        $userCardId = $command[1];
        /** @var UserCard|null $userCard */
        $userCard = $this->entityManager->createQueryBuilder()
            ->select('userCard')
            ->from('CardsListBotBundle:UserCard', 'userCard')
            ->where('userCard.id = :id')
            ->andWhere('userCard.user = :userId')
            ->setParameters(
                [
                    'id' => $userCardId,
                    'userId' => $this->getMessage()->getFrom()->getId(),
                ]
            )
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $userCard) {
            $data['text'] = 'Карта не найдина, выберете другую карту из списка /list';

            return Request::sendMessage($data);
        }

        $data = [
            'chat_id' => $message->getChat()->getId(),
            'text' => sprintf(
                '👤 %s '.PHP_EOL.'💳 %s',
                $userCard->getCustomName(),
                $userCard->getCard()->getNumber()
            ),
            'reply_markup' => [
                'inline_keyboard' => [
                    [
                        [
                            'text' => '🗣',
                            'switch_inline_query' => 'sendCard:'.$userCard->getId(),
                        ],
                        [
                            'text' => '✏️',
                            'callback_data' => 'editCard:'.$userCard->getId(),
                        ],
                        [
                            'text' => '❌',
                            'callback_data' => 'deleteCard:'.$userCard->getId(),
                        ],
                    ],
                ],
            ],
        ];
        $a = Request::sendMessage($data);
        print_r($a);

        return $a;
    }
}
