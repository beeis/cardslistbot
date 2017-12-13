<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use CardsList\BotBundle\Entity\CreditCard;
use Doctrine\ORM\EntityManagerInterface;
use Longman\TelegramBot\Request;

/**
 * Class ListCommand
 *
 * @package CardsList\BotBundle\Command\Bot
 */
class ListCommand extends BotCommand
{
    const NAME = 'list';

    /**
     * Name
     *
     * @var string
     */
    protected $name = 'list';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Get cards list';

    /**
     * Usage
     *
     * @var string
     */
    protected $usage = '/list';

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
        $chat_id = $message->getChat()->getId();

        /** @var CreditCard[] $cards */
        $cards = $this->entityManager->createQueryBuilder()
            ->select('card')
            ->from('CardsListBotBundle:CreditCard', 'card')
            ->where('card.user = :user_id')
            ->setParameter('user_id', $this->getMessage()->getFrom()->getId())
            ->getQuery()
            ->getResult();

        $data = ['chat_id' => $chat_id,];

        $text = '';
        $i = 0;

        foreach ($cards as $card) {
            $text .= sprintf(
                '%s. 👤 %s '.PHP_EOL.'💳 ****%s 👉 /%s_%s'.PHP_EOL,
                ++$i,
                $card->getHolderName(),
                substr($card->getNumber(), -4),
                CardCommand::NAME,
                $card->getId()
            );
        }

        if (true === empty($text)) {
            $data['text'] = 'Ваш список пуст 😞'.PHP_EOL.PHP_EOL.
                'Просто отправьте мне номер карты!😊';

            return Request::sendMessage($data);
        }

        $data['text'] = 'Список сохраненных карт:'.PHP_EOL.PHP_EOL.$text.PHP_EOL.PHP_EOL.
            'Жмите команду '.CardCommand::NAME.' чтобы: '.PHP_EOL.'✏️ Изменить имя'.PHP_EOL.'❌ Удалить'.PHP_EOL.'🗣 Поделиться';

        return Request::sendMessage($data);
    }
}
