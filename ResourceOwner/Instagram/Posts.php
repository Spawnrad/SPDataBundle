<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Instagram;

use Symfony\Component\OptionsResolver\OptionsResolver;
use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;

class Posts extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'identifier' => 'data.0.id',
        'title' => null,
        'description' => 'data.0.caption',
        'shortcode' => 'data.0.shortcode',
        'link' => 'data.0.permalink',
        'thumbnail' => 'data.0.media_url',
        'publishedAt' => 'data.0.timestamp',
        'userId' => 'owner.id',        
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
            'infos_url' => 'https://graph.facebook.com/{instagram-id}/media',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ));
    }
}
