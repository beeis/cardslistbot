<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Manager;

use CardsList\BotBundle\Entity\CreditCard;
use CardsList\BotBundle\Entity\User;
use CardsList\BotBundle\Exception\CardsListBotException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class CreditCardManager
 *
 * @package CardsList\BotBundle\Manager
 */
class CreditCardManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CreditCardManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $cardId
     * @param User $user
     *
     * @throws CardsListBotException
     * @return bool Return true on success otherwise throws error
     */
    public function cloneToUser($cardId, User $user)
    {
        $creditCard = $this->findCard($cardId);
        if (null === $creditCard) {
            throw new CardsListBotException('Произошла ошибка, карта не найдена');
        }

        if (true === $this->hasUserNumber($user, $creditCard->getNumber())) {
            throw new CardsListBotException('Эта карта уже сохранена');
        }

        $creditCard = clone $creditCard;
        $creditCard->setUser($user);
        $this->entityManager->persist($creditCard);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @param $id
     *
     * @return CreditCard|null
     */
    public function findCard($id): ?CreditCard
    {
        try {
            return $this->entityManager->createQueryBuilder()
                ->from('CardsListBotBundle:CreditCard', 'credit_card')
                ->select('credit_card')
                ->where('credit_card.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $exception) {
            return null;
        }
    }

    /**
     * @param User $user
     * @param string $number
     *
     * @return bool
     */
    public function hasUserNumber(User $user, string $number): bool
    {
        return (bool) $this->findByUserNumber($user, $number);
    }

    /**
     * @param User $user
     * @param string $number
     *
     * @return CreditCard|null
     */
    public function findByUserNumber(User $user, string $number): ?CreditCard
    {
        try {
            return $this->entityManager->createQueryBuilder()
                ->from('CardsListBotBundle:CreditCard', 'credit_card')
                ->select('credit_card')
                ->where('credit_card.user = :user')
                ->andWhere('credit_card.number = :number')
                ->setParameters(
                    [
                        'user' => $user,
                        'number' => $number,
                    ]
                )
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $exception) {
            return null;
        }
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function delete($id)
    {
        return $this->entityManager->createQueryBuilder()
            ->delete('CardsListBotBundle:CreditCard', 'credit_card')
            ->where('credit_card.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
