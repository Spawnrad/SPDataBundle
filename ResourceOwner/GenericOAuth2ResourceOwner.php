<?php

namespace SP\Bundle\DataBundle\ResourceOwner;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class GenericOAuth2ResourceOwner extends AbstractResourceOwner
{
    /**
     * {@inheritdoc}
     */
    public function getInformation(array $extraParameters = array())
    {
        $headers = $this->getHeaderInformation();

        if (isset($extraParameters['postId'])) {
            $url = str_replace('{post-id}', $extraParameters['postId'], $this->options['infos_url']);
            unset($extraParameters['postId']);
        } else {
            $url = $this->options['infos_url'];
        }
        if ($this->options['use_bearer_authorization']) {
            $content = $this->httpRequest($this->normalizeUrl($url, $extraParameters), null, $headers);
        } else {
            $content = $this->httpRequest($this->normalizeUrl($url, array_merge($headers, $extraParameters)));
        }
        $response = $this->getDataResponse();
        $response->setResponse($content->getBody());
        $response->setStatusCode($content->getStatusCode());
        if ($content->getHeader('Etag')) {
            $response->setEtag($content->getHeader('Etag')[0]);
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
    protected function httpRequest($url, $content = null, array $headers = [], $method = null)
    {
        $headers += array('Content-Type' => 'application/x-www-form-urlencoded');

        return parent::httpRequest($url, $content, $headers, $method);
    }
}
