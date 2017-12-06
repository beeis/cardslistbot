<?php

declare(strict_types=1);

namespace CardsList\BotBundle;

use CardsList\BotBundle\DependencyInjection\Compiler\CommandCompiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class CardsListBotBundle
 *
 * @package CardsList\BotBundle
 */
class CardsListBotBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CommandCompiler());
    }
}
