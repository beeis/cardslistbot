<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Command\Bot;

use CardsList\BotBundle\Entity\CreditCard;
use Doctrine\ORM\EntityManagerInterface;
use Inacho\CreditCard as InachoCreditCard;
use Longman\TelegramBot\Request;

/**
 * Class InlineQueryCommand
 *
 * @package CardsList\BotBundle\Command\Bot
 */
class InlineQueryCommand extends BotCommand
{
    /**
     * @var string
     */
    protected $name = 'inlinequery';

    /**
     * @var string
     */
    protected $description = 'Reply to inline query';

    /**
     * @var string
     */
    protected $version = '1.0.0';

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
     * {@inheritdoc}
     */
    public function execute()
    {
        $inline_query = $this->getUpdate()->getInlineQuery();
        $user = $inline_query->getFrom();
        $query = $inline_query->getQuery();

        $expr = $this->entityManager->createQueryBuilder()->expr();

        $creditCards = $this->entityManager
            ->createQueryBuilder()
            ->select('credit_card')
            ->from('CardsListBotBundle:CreditCard', 'credit_card')
            ->orWhere($expr->like('credit_card.holderName', ':query'))
            ->orWhere('credit_card.number = :number')
            ->andWhere('credit_card.user = :user_id')
            ->setParameters(
                [
                    'user_id' => $user->getId(),
                    'query' => '%'.$query.'%',
                    'number' => $query,
                ]
            )
            ->getQuery()
            ->getResult();

        $results = [];
        /** @var CreditCard $creditCard */
        foreach ($creditCards as $creditCard) {
            $results[] = [
                'type' => 'article',
                'id' => $creditCard->getId(),
                'title' => sprintf(
                    '👤 %s ****%s',
                    $creditCard->getHolderName(),
                    substr($creditCard->getNumber(), -4)
                ),
                'input_message_content' => [
                    'message_text' => sprintf(
                        '👤 %s '.PHP_EOL.'💳 %s',
                        $creditCard->getHolderName(),
                        $creditCard->getNumber()
                    ),
                ],
                'reply_markup' => [
                    'inline_keyboard' => [
                        [
                            [
                                'text' => '➕ Сохранить',
                                //TODO: check is callback_data is not over 64bytes
                                'callback_data' => json_encode(
                                    [
                                        'command' => 'cloneToUser',
                                        'card_id' => $creditCard->getId(),
                                    ]
                                ),
                            ],
                        ],
                    ],
                ],
                'description' => '💳'.$creditCard->getNumber(),
                'thumb_url' => $creditCard->getLogoImage(),
                'thumb_width' => 10,
                'thumb_height' => 10,
            ];
        }

        if (true === empty($results)) {
            $card = InachoCreditCard::validCreditCard($query);
            if (true === $card['valid']) {
                $switch_pm_text = 'Сохранить эту карту';
                $switch_pm_parameter = $card['number'];
            } else {
                $switch_pm_text = 'Добавить новую карту';
                $switch_pm_parameter = 'none';
            }

            $res =  Request::answerInlineQuery(
                [
                    'inline_query_id' => $this->getUpdate()->getInlineQuery()->getId(),
                    'cache_time' => 0, //for dev env
                    'results' => [],
                    'switch_pm_text' => $switch_pm_text,
                    'switch_pm_parameter' => $switch_pm_parameter
                ]
            );

            return $res;
        }

        return Request::answerInlineQuery(
            [
                'inline_query_id' => $this->getUpdate()->getInlineQuery()->getId(),
                'cache_time' => 0, //for dev env
                'results' => $results,
            ]
        );
    }
}
