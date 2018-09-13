<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Youtube;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;
use SP\Bundle\DataBundle\ResourceOwner\Youtube\Behavior\ListTrait;

class Channel extends GenericOAuth2ResourceOwner
{
    use ListTrait;

    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'items' => 'items'
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url' => 'https://www.googleapis.com/youtube/v3/channels',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ));
    }
}