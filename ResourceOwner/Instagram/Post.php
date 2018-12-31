<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Instagram;

use Symfony\Component\OptionsResolver\OptionsResolver;
use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;

class Post extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'identifier' => 'id',
        'title' => null,
        'description' => 'caption',
        'link' => 'permalink',
        'shortcode' => 'shortcode',
        'thumbnail' => 'media_url',
        'publishedAt' => 'timestamp',
        'userId' => 'owner.id',
        'items' => null,
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
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ));
    }
}
