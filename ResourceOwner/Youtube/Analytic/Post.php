<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Youtube\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Post extends GenericOAuth2ResourceOwner
{
    protected $paths = [
        'viewCount' => 'items.0.statistics.viewCount',
        'commentCount' => 'items.0.statistics.commentCount',
        'likeCount' => 'items.0.statistics.likeCount',
        'shareCount' => null,
        'error' => 'error.message',
    ];

    /**
     * @param string $id
     *
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

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://www.googleapis.com/youtube/v3/videos',
            'response_class' => 'SP\Bundle\DataBundle\Response\Analytic\PathResponse',
        ]);
    }
}
