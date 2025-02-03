<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Instagram\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Channel extends GenericOAuth2ResourceOwner
{
    protected $paths = [
        'identifier' => 'id',
        'subscriberCount' => 'followers_count',
        'postCount' => 'media_count',
        'followers' => 'followers_count',
        'profilepicture' => 'profile_picture_url',
        'name' => 'username',
        'items' => 'data.0.values',
        'item_name' => 'data.0.name',
        'error' => 'error.message',
    ];

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://graph.facebook.com/v15.0/{instagram-id}',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',
        ]);
    }
}
