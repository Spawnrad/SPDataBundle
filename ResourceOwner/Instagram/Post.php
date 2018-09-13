<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Instagram;

use Symfony\Component\OptionsResolver\OptionsResolver;
use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;

class Post extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'identifier' => 'data.0.id',
        'title' => null,
        'description' => 'data.0.caption.text',
        'link' => 'data.0.link',
        'thumbnail' => 'data.0.images.standard_resolution.url',
        'publishedAt' => 'data.0.created_time',
        'userId' => 'data.0.user.id',
        'items' => 'data',
        'error' => 'meta.error_message',
        'pagination' => 'pagination'
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url' => 'https://api.instagram.com/v1/media/{post-id}',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',

            // Instagram supports authentication with only one defined URL
            'auth_with_one_url' => true,

            'use_bearer_authorization' => false,
        ));
    }
}
