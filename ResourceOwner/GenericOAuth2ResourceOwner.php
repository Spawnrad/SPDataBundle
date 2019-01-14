<?php

namespace SP\Bundle\DataBundle\ResourceOwner;

use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenericOAuth2ResourceOwner extends AbstractResourceOwner
{
    /**
     * {@inheritdoc}
     */
    public function getInformation(array $extraParameters = array(), $content = null)
    {
        $headers = $this->getHeaderInformation();

        if (isset($extraParameters['postId'])) {
            $url = str_replace('{post-id}', $extraParameters['postId'], $this->options['infos_url']);
            unset($extraParameters['postId']);
        } elseif (isset($extraParameters['instagramId'])) {
            $url = str_replace('{instagram-id}', $extraParameters['instagramId'], $this->options['infos_url']);
            unset($extraParameters['instagramId']);
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

    protected function getHeaderInformation()
    {
        $headers = array();

        if ($this->access_token) {
            if ($this->options['use_bearer_authorization']) {
                $headers = array('Authorization' => 'Bearer ' . $this->access_token);
            } else {
                $headers = array($this->options['attr_name'] => $this->access_token);
            }
        }

        return $headers;
    }

    /**
     * {@inheritDoc}
     */
    protected function doGetInformationRequest($url, array $parameters = array())
    {
        return $this->httpRequest($url, http_build_query($parameters, '', '&'));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'attr_name' => 'access_token',
            'use_bearer_authorization' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function httpRequest($url, $content = null, $headers = [], $method = null)
    {
        $headers += array('Content-Type' => 'application/x-www-form-urlencoded');

        return parent::httpRequest($url, $content, $headers, $method);
    }
}
