<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Instagram;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Posts extends GenericOAuth2ResourceOwner
{
    protected $paths = [
        'identifier' => 'data.0.id',
        'title' => 'data.0.media_type',
        'description' => 'data.0.caption',
        'shortcode' => 'data.0.shortcode',
        'link' => 'data.0.permalink',
        'thumbnail' => 'data.0.thumbnail_url',
        'media' => 'data.0.media_url',
        'publishedAt' => 'data.0.timestamp',
        'userId' => 'data.0.owner.id',
        'items' => 'data',
        'error' => 'error.message',
        'pagination' => 'paging.cursors.after',
    ];

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://graph.facebook.com/{instagram-id}/media',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ]);
    }
}
