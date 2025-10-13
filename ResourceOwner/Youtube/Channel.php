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

    public function getInformation(array $extraParameters = [], $content = null)
    {
        $headers = $this->getHeaderInformation();

        if (isset($extraParameters['channelId'])) {
            $url = $this->options['infos_url'];
            $url = str_replace('&mine=true', '', $url);
            $url .= '&id=' . $extraParameters['channelId'];
            $url .= '&key=' . $_ENV['DATA_YOUTUBE_KEY'];

            unset($extraParameters['channelId']);
        } else {
            $url = $this->options['infos_url'];
        }

        if ($this->options['use_bearer_authorization']) {
            $result = $this->httpRequest($this->normalizeUrl($url, $extraParameters), $content, $headers);
        } else {
            $result = $this->httpRequest($this->normalizeUrl($url, array_merge($headers, $extraParameters)), $content);
        }

        $response = $this->getDataResponse();
        $response->setResponse($result->getBody());
        $response->setStatusCode($result->getStatusCode());
        if ($result->getHeader('Etag')) {
            $response->setEtag($result->getHeader('Etag')[0]);
        }
        $response->setResourceOwner($this);

        return $response;
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://www.googleapis.com/youtube/v3/channels',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ]);
    }
}
