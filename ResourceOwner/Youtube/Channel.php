<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Youtube;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use SP\Bundle\DataBundle\ResourceOwner\Youtube\Behavior\ListTrait;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Channel extends GenericOAuth2ResourceOwner
{
    use ListTrait;

    protected $paths = [
        'items' => 'items',
    ];

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://www.googleapis.com/youtube/v3/channels',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ]);
    }
}
