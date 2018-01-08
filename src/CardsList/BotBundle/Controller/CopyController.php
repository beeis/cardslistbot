<?php

declare(strict_types=1);

namespace CardsList\BotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CopyController
 *
 * @package CardsList\BotBundle\Controller
 */
class CopyController extends Controller
{
    public function indexAction(string $number)
    {
        return new JsonResponse(['ok' => true, 'result' => $number]);
    }
}
