<?php

namespace SP\Data;

use SP\Data\DependencyInjection\SPDataExtension;
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
