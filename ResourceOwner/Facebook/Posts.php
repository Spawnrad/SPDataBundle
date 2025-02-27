<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Facebook;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Posts extends GenericOAuth2ResourceOwner
{
    protected $paths = [
        'identifier' => 'data.0.id',
        'title' => 'data.0.status_type',
        'description' => 'data.0.message',
        'link' => 'data.0.attachments.data.0.unshimmed_url',
        'thumbnail' => 'data.0.full_picture',
        'publishedAt' => 'data.0.created_time',
        'items' => 'data',
        'error' => 'error.message',
    ];

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://graph.facebook.com/v15.0/me/posts',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ]);
    }
}
