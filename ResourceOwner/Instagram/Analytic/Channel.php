<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Instagram\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Channel extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'subscriberCount' => 'data.counts.followed_by',
        'postCount'       => 'data.counts.media',
        'error'           => 'meta.error_message',
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url'                 => 'https://api.instagram.com/v1/users/self',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',

            // Instagram supports authentication with only one defined URL
            'auth_with_one_url'        => true,
            'use_bearer_authorization' => false,
        ));
    }
}