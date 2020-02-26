<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Facebook\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Channel extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'items'         => 'data.0.values',
        'item_name'     => 'data.0.name',
        'subscriberCount' => 'fan_count',
        'error'         => 'error.message'
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url'      => 'https://graph.facebook.com/v3.0/me/insights/',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',
        ));
    }
}