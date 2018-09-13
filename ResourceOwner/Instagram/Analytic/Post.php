<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Instagram\Analytic;

use Symfony\Component\OptionsResolver\OptionsResolver;
use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;

class Post extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'identifier' => 'data.0.id',
        'viewCount' => null,
        'commentCount' => 'data.0.comments.count',
        'likeCount' => 'data.0.likes.count',
        'shareCount' => null,
        'error' => 'meta.error_message',
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
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',

            // Instagram supports authentication with only one defined URL
            'auth_with_one_url' => true,

            'use_bearer_authorization' => false,
        ));
    }
}
