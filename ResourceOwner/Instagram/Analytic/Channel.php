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
        'identifier' => 'id',
        'followers' => 'followers_count',
        'profilepicture' => 'profile_picture_url',
        'name' => 'username',
        'items'         => 'data.0.values',
        'item_name'     => 'data.0.name',
        'error'         => 'error.message'
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url'      => 'https://graph.facebook.com/v3.0/{instagram-id}',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',
        ));
    }
}