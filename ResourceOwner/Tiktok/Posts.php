<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Tiktok;

use Symfony\Component\OptionsResolver\OptionsResolver;
use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;

class Posts extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
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
        'has_more' => 'data.has_more'
    );

    /**
     * {@inheritdoc}
     */
    public function getInformation(array $extraParameters = [], $content = [])
    {
        $headers = $this->getHeaderInformation();

        if (!empty($content)) {
            $content = json_encode($content);
        }

        $url = $this->options['infos_url'];
        $result = $this->httpRequest($this->normalizeUrl($url, $extraParameters), $content, $headers, 'POST');

        $response = $this->getDataResponse();
        $response->setResponse($result->getBody());
        $response->setStatusCode($result->getStatusCode());
        $response->setResourceOwner($this);

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url' => 'https://open.tiktokapis.com/v2/video/list/',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ));
    }
}
