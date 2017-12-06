<?php

declare(strict_types=1);

namespace CardsList\BotBundle\DependencyInjection\Compiler;

use CardsList\BotBundle\Command\Bot\BotCommand;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CommandCompiler
 *
 * @package CardsList\BotBundle\DependencyInjection\Compiler
 */
class CommandCompiler implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('longman.telegram-bot');
        $taggedServices = $container->findTaggedServiceIds('telegram.command');

        foreach ($taggedServices as $id => $tags) {
            // add the transport service to the ChainTransport service
            $definition->addMethodCall('addCommand', array(array_shift($tags)['command'], new Reference($id)));
        }
    }
}
