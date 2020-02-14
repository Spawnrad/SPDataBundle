<?php

namespace SP\Bundle\DataBundle;

use SP\Bundle\DataBundle\DependencyInjection\CompilerPass\SetResourceOwnerServiceNameCompilerPass;
use SP\Bundle\DataBundle\DependencyInjection\SPDataExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SPDataBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SetResourceOwnerServiceNameCompilerPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new SPDataExtension();
    }
}
