<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Instagram;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Post extends GenericOAuth2ResourceOwner
{
    protected $paths = [
        'identifier' => 'id',
        'title' => 'media_type',
        'description' => 'caption',
        'link' => 'permalink',
        'shortcode' => 'shortcode',
        'thumbnail' => 'thumbnail_url',
        'media' => 'media_url',
        'publishedAt' => 'timestamp',
        'userId' => 'owner.id',
        'items' => null,
        'error' => 'error.message',
    ];

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://graph.facebook.com/{post-id}',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ]);
    }
}
