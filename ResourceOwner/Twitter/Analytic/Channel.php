<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Twitter\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth1ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Channel extends GenericOAuth1ResourceOwner
{
    protected $paths = [
        'subscriberCount' => 'followers_count',
        'postCount' => 'statuses_count',
        'error' => 'errors.0.message',
    ];

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://api.twitter.com/1.1/account/verify_credentials.json',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',
        ]);

        $resolver->setDefined('x_auth_access_type');
        // @link https://dev.twitter.com/oauth/reference/post/oauth/request_token
        $resolver->setAllowedValues('x_auth_access_type', ['read', 'write']);
    }
}
