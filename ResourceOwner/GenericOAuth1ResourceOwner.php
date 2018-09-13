<?php

namespace SP\Bundle\DataBundle\ResourceOwner;

use SP\Bundle\DataBundle\Utils\DataUtils;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class GenericOAuth1ResourceOwner extends AbstractResourceOwner
{
    protected $access_token_secret;

    /**
     * {@inheritdoc}
     */
    public function getInformation(array $extraParameters = array())
    {
        $parameters = array(
            'oauth_consumer_key' => $this->options['client_id'],
            'oauth_timestamp' => time(),
            'oauth_nonce' => $this->generateNonce(),
            'oauth_version' => '1.0',
            'oauth_signature_method' => $this->options['signature_method'],
            'oauth_token' => $this->access_token,
        );

        if ($extraParameters) {
            $url = $this->normalizeUrl($this->options['infos_url'], $extraParameters);
        } else {
            $url = $this->options['infos_url'];
        }
        $parameters['oauth_signature'] = DataUtils::signRequest(
            'GET',
            $url,
            $parameters,
            $this->options['client_secret'],
            $this->access_token_secret,
            $this->options['signature_method']
        );

        $content = $this->doGetInformationRequest($url, $parameters);
        $response = $this->getDataResponse();
        $response->setResponse($content->getBody());
        $response->setStatusCode($content->getStatusCode());

        if ($content->getHeader('Etag')) {
            $response->setEtag($content->getHeader('Etag')[0]);
        }

        $response->setResourceOwner($this);

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    protected function httpRequest($url, $content = null, $parameters = array(), $headers = array(), $method = null)
    {
        foreach ($parameters as $key => $value) {
            $parameters[$key] = $key . '="' . rawurlencode($value) . '"';
        }

        if (!$this->options['realm']) {
            array_unshift($parameters, 'realm="' . rawurlencode($this->options['realm']) . '"');
        }

        $headers = array('Authorization' => 'OAuth ' . implode(', ', $parameters));

        return parent::httpRequest($url, $content, $headers, $method);
    }

    /**
     * {@inheritdoc}
     */
    protected function doGetInformationRequest($url, array $parameters = array())
    {
        return $this->httpRequest($url, null, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired(array(
            'client_id',
            'client_secret',
        ));

        $resolver->setDefaults(array(
            'realm' => null,
            'signature_method' => 'HMAC-SHA1',
        ));

        $resolver->setAllowedValues('signature_method', array('HMAC-SHA1', 'RSA-SHA1', 'PLAINTEXT'));
    }

    public function getAccessTokenSecret()
    {
        return $this->access_token_secret;
    }

    public function setAccessTokenSecret($access_token_secret)
    {
        $this->access_token_secret = $access_token_secret;
    }
}
