<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Facebook;

use Symfony\Component\OptionsResolver\OptionsResolver;
use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;

class Post extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'identifier'    => 'id',
        'title'         => 'status_type',
        'description'   => 'message',
        'link'          => null,
        'thumbnail'     => 'full_picture',
        'publishedAt'   => 'created_time',
        'items'         => null,
        'userId'        => 'from.id',
        'error'         => 'error.message'
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url'      => 'https://graph.facebook.com/v3.0/{post-id}?fields=id,description,message,link,full_picture,status_type,type,created_time',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ));
    }
}