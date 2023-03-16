<?php

namespace SP\Bundle\DataBundle;

use SP\Bundle\DataBundle\DependencyInjection\SPDataExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class SPDataBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        return $this->extension ?: $this->extension = $this->createContainerExtension();
    }
}
