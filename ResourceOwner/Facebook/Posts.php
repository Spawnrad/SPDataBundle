<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Facebook;

use Symfony\Component\OptionsResolver\OptionsResolver;
use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;

class Posts extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'identifier'    => 'data.0.id',
        'title'         => 'data.0.status_type',
        'description'   => 'data.0.message',
        'link'          => null,
        'thumbnail'     => 'data.0.full_picture',
        'publishedAt'   => 'data.0.created_time',
        'items'         => 'data',
        'error'         => 'error.message'
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url'      => 'https://graph.facebook.com/v3.0/me/posts',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ));
    }
}