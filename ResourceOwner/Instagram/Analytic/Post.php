<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Instagram\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Post extends GenericOAuth2ResourceOwner
{
    protected $paths = [
        'identifier' => 'id',
        'viewCount' => 'insights.data.0.values.0.value',
        'commentCount' => 'comments_count',
        'likeCount' => 'like_count',
        'shareCount' => null,
        'items' => 'data',
        'error' => 'error.message',
        'pagination' => 'paging.cursors.after',
    ];

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://graph.facebook.com/{post-id}',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',
        ]);
    }
}
