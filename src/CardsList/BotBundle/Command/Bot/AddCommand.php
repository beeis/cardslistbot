<?php


namespace CardsList\BotBundle\Command\Bot;

use Doctrine\ORM\EntityManagerInterface;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

/**
 * Class AddCommand
 *
 * @package CardsList\BotBundle\Command\Bot
 */
class AddCommand extends BotCommand
{
    /**
     * Name
     *
     * @var string
     */
    protected $name = 'add';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Start conversation for adding new credit card';

    /**
     * Usage
     *
     * @var string
     */
    protected $usage = '/add';

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

        $data = [
            'chat_id' => $chat_id,
            'text' => 'Отправь мне номер карты чтобы соханить в свой личный список.'
        ];

        return Request::sendMessage($data);
    }
}
