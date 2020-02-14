<?php

namespace SP\Bundle\DataBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Set the appropriate name for aliased services.
 *
 * @author Tomas Pecserke <tomas.pecserke@gmail.com>
 */
final class SetResourceOwnerServiceNameCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        foreach (array_keys($container->getAliases()) as $alias) {
            if (0 !== strpos($alias, 'sp_data.resource_owner.')) {
                continue;
            }

            $aliasIdParts = explode('.', $alias);
            $resourceOwnerDefinition = $container->findDefinition($alias);
            $resourceOwnerDefinition->addMethodCall('setName', [end($aliasIdParts)]);
        }
    }
}