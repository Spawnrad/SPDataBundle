<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Twitter;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth1ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Posts extends GenericOAuth1ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'identifier'  => '0.id_str',
        'title'       => null,
        'description' => '0.full_text',
        'link'        => null,
        'thumbnail'   => '0.entities.media.0.media_url',
        'publishedAt' => '0.created_at',
        'items'       => null,
        'error'       => 'errors.0.message'
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url' => 'https://api.twitter.com/1.1/statuses/user_timeline.json?exclude_replies=true&include_rts=false&tweet_mode=extended',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ));

        $resolver->setDefined('x_auth_access_type');
        // @link https://dev.twitter.com/oauth/reference/post/oauth/request_token
        $resolver->setAllowedValues('x_auth_access_type', array('read', 'write'));
    }
}