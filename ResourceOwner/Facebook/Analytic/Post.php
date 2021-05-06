<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Facebook\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Post extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'identifier' => 'id',
        'viewCount' => 'insights.data.0.values.0.value',
        'commentCount' => 'comments.summary.total_count',
        'likeCount' => 'likes.summary.total_count',
        'shareCount' => 'shares.count',
        'error' => 'error.message',
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url' => 'https://graph.facebook.com/v10.0/{post-id}?fields=likes.summary(true),comments.summary(true),shares,insights.metric(post_impressions_unique)',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',
        ));
    }
}
