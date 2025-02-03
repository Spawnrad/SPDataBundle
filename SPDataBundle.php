<?php

namespace SP\Bundle\DataBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SPDataBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return $this->extension ?: $this->extension = $this->createContainerExtension();
    }
}
