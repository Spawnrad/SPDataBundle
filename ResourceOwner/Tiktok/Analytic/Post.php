<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Tiktok\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Post extends GenericOAuth2ResourceOwner
{
    protected $paths = [
        'identifier' => 'data.videos.0.id',
        'title' => 'data.videos.0.title',
        'description' => 'data.videos.0.video_description',
        'shortcode' => 'data.videos.0.shortcode',
        'link' => 'data.videos.0.share_url',
        'thumbnail' => 'data.videos.0.cover_image_url',
        'publishedAt' => 'data.videos.0.create_time',

        'viewCount' => 'data.videos.0.view_count',
        'commentCount' => 'data.videos.0.comment_count',
        'likeCount' => 'data.videos.0.like_count',
        'shareCount' => 'data.videos.0.share_count',

        'items' => 'data.videos',
        'error' => 'error.message',
        'pagination' => 'data.cursor',
        'has_more' => 'data.has_more',
    ];

    public function getInformation(array $extraParameters = [], $posts = [])
    {
        $headers = $this->getHeaderInformation();

        if (!empty($posts)) {
            $content = json_encode([
                'filters' => [
                    'video_ids' => $posts,
                ],
            ]);
        }

        $url = $this->options['infos_url'];
        $result = $this->httpRequest($this->normalizeUrl($url, $extraParameters), $content, $headers, 'POST');

        $response = $this->getDataResponse();
        $response->setResponse($result->getBody());
        $response->setStatusCode($result->getStatusCode());
        $response->setResourceOwner($this);

        return $response;
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://open.tiktokapis.com/v2/video/query/',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ]);
    }
}
