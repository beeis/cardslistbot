<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CopyController
 *
 * @package CardsList\BotBundle\Controller
 */
class CopyController extends Controller
{
    /**
     * @param string $number
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(string $number)
    {
        return $this->render(
            'CardsListBotBundle:Copy:index.html.twig',
            [
                'number' => $number,
            ]
        );
    }

}
