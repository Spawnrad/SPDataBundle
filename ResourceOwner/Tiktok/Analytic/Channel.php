<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Tiktok\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Channel extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'identifier' => 'data.user.open_id',
        'name' => 'data.user.display_name',
        'profilepicture' => 'data.user.avatar_url',   
        'subscriberCount' => 'data.user.follower_count',
        'likeCount' => 'data.user.likes_count',

        'items' => 'data.user',
        'error' => 'error.message',
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url' => 'https://open.tiktokapis.com/v2/user/info/',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',
        ));
    }
}
