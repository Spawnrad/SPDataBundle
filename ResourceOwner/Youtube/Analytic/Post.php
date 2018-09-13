<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Youtube\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\Youtube\Behavior\ListTrait;
use Symfony\Component\OptionsResolver\OptionsResolver;
use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;

class Post extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'viewCount'            => 'items.0.statistics.viewCount',
        'commentCount'         => 'items.0.statistics.commentCount',
        'likeCount'            => 'items.0.statistics.likeCount',
        'shareCount'           => null,
        'error'                => 'error.message',
    );

    /**
     * @param  string $id
     * @param  array $parts
     * @param  array $otherParameters
     * @return array
     */
    public function listById($id, array $parts = ['statistics'], array $otherParameters = [])
    {
        $parameters = array_merge(
            ['part' => implode(',', $parts), 'id' => $id],
            $otherParameters
        );
        return $this->getInformation($parameters);
    }

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url'      => 'https://www.googleapis.com/youtube/v3/videos',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',
        ));
    }
}