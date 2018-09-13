<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Twitter\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth1ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Post extends GenericOAuth1ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'viewCount'    => null,
        'commentCount' => null,
        'likeCount'    => 'favorite_count',
        'shareCount'   => 'retweet_count',
        'error'       => 'errors.0.message'
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url' => 'https://api.twitter.com/1.1/statuses/show.json',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',
        ));

        $resolver->setDefined('x_auth_access_type');
        // @link https://dev.twitter.com/oauth/reference/post/oauth/request_token
        $resolver->setAllowedValues('x_auth_access_type', array('read', 'write'));
    }
}