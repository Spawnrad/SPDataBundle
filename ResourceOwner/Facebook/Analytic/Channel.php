<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Facebook\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Channel extends GenericOAuth2ResourceOwner
{
    protected $paths = [
        'items' => 'data.0.values',
        'item_name' => 'data.0.name',
        'subscriberCount' => 'followers_count',
        'error' => 'error.message',
    ];

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://graph.facebook.com/v15.0/me/insights/',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',
        ]);
    }
}
