<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Facebook;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Post extends GenericOAuth2ResourceOwner
{
    protected $paths = [
        'identifier' => 'id',
        'title' => 'status_type',
        'description' => 'message',
        'link' => 'attachments.data.0.unshimmed_url',
        'thumbnail' => 'full_picture',
        'publishedAt' => 'created_time',
        'items' => null,
        'userId' => 'from.id',
        'error' => 'error.message',
    ];

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://graph.facebook.com/v15.0/{post-id}?fields=id,description,message,link,full_picture,status_type,type,created_time',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ]);
    }
}
