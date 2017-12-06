<?php

declare(strict_types=1);

namespace CardsList\Callback;

use Longman\TelegramBot\Entities\CallbackQuery;

/**
 * Class CoreCallback
 *
 * @package CardsList\Callback
 */
interface CoreCallback
{
    /**
     * @param CallbackQuery $callbackQuery
     *
     * @return mixed
     */
    public function execute(CallbackQuery $callbackQuery);
}
