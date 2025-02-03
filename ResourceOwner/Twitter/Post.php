<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Twitter;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth1ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Post extends GenericOAuth1ResourceOwner
{
    protected $paths = [
        'identifier' => 'id_str',
        'title' => null,
        'description' => 'full_text',
        'link' => null,
        'thumbnail' => 'entities.media.0.media_url',
        'publishedAt' => 'created_at',
        'userId' => 'user.id_str',
        'items' => null,
        'error' => 'errors.0.message',
    ];

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://api.twitter.com/1.1/statuses/show.json?exclude_replies=true&tweet_mode=extended',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ]);

        $resolver->setDefined('x_auth_access_type');
        // @link https://dev.twitter.com/oauth/reference/post/oauth/request_token
        $resolver->setAllowedValues('x_auth_access_type', ['read', 'write']);
    }
}
