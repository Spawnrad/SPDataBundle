<?php

namespace SP\Bundle\DataBundle;

use SP\Bundle\DataBundle\DependencyInjection\SPDataExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SPDataBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new SPDataExtension();
    }
}
