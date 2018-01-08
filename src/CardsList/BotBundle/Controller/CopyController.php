<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
     * @return Response
     */
    public function indexAction(string $number): Response
    {
        return $this->render(
            'CardsListBotBundle:Copy:index.html.twig',
            [
                'number' => $number,
            ]
        );
    }

}
