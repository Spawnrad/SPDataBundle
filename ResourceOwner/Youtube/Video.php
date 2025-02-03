<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Youtube;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use SP\Bundle\DataBundle\ResourceOwner\Youtube\Behavior\ListTrait;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Video extends GenericOAuth2ResourceOwner
{
    use ListTrait;

    protected $paths = [
        'identifier' => 'items.0.id',
        'title' => 'items.0.snippet.title',
        'description' => 'items.0.snippet.description',
        'link' => null,
        'thumbnail' => 'items.0.snippet.thumbnails.medium.url',
        'publishedAt' => 'items.0.snippet.publishedAt',
        'userId' => 'items.0.snippet.channelId',
        'items' => 'items',
        'error' => 'error.message',
    ];

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://www.googleapis.com/youtube/v3/videos',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ]);
    }
}
