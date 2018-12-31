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
        'identifier' => 'id',
        'viewCount' => 'insights.data.0.values.0.value',
        'commentCount' => 'comments_count',
        'likeCount' => 'like_count',
        'shareCount' => null,
        'items' => 'data',
        'error' => 'error.message',
        'pagination' => 'paging.cursors.after'
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url' => 'https://graph.facebook.com/{post-id}',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',
        ));
    }
}
