<?php

namespace SP\Bundle\DataBundle\ResourceOwner;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Exception;
use SP\Bundle\DataBundle\Exception\HttpTransportException;
use SP\Bundle\DataBundle\Response\Data\PathResponse as PathDataResponse;
use SP\Bundle\DataBundle\Response\Analytic\PathResponse as PathAnalyticResponse;
use SP\Bundle\DataBundle\Response\Data\DataResponseInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Http\HttpUtils;

abstract class AbstractResourceOwner implements ResourceOwnerInterface
{
    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var array
     */
    protected $paths = array();

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $access_token;

    /**
     * @var string
     */
    protected $etag;

    /**
     * @param HttpClientInterface $httpClient Buzz http client
     * @param array $options Options for the resource owner
     * @param string $name Name for the resource owner
     */
    public function __construct(
        HttpMethodsClient $httpClient,
        HttpUtils $httpUtils,
        array $options,
        $name
    ) {
        $this->httpClient = $httpClient;
        $this->httpUtils = $httpUtils;
        $this->name = $name;

        if (!empty($options['paths'])) {
            $this->addPaths($options['paths']);
        }
        unset($options['paths']);

        if (!empty($options['options'])) {
            $options += $options['options'];
            unset($options['options']);
        }
        unset($options['options']);

        // Resolve merged options
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);

        $this->configure();
    }

    /**
     * Gives a chance for extending providers to customize stuff.
     */
    public function configure()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new \InvalidArgumentException(sprintf('Unknown option "%s"', $name));
        }

        return $this->options[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function addPaths(array $paths)
    {
        $this->paths = array_merge($this->paths, $paths);
    }

    /**
     * Get the response object to return.
     *
     * @return DataResponseInterface
     */
    protected function getDataResponse()
    {
        $response = new $this->options['response_class'];
        if ($response instanceof PathDataResponse || $response instanceof PathAnalyticResponse) {
            $response->setPaths($this->paths);
        }

        return $response;
    }

    /**
     * @param string $url
     * @param array $parameters
     *
     * @return string
     */
    protected function normalizeUrl($url, array $parameters = array())
    {
        $normalizedUrl = $url;
        if (!empty($parameters)) {
            $normalizedUrl .= (false !== strpos($url, '?') ? '&' : '?') . http_build_query($parameters, '', '&');
        }

        return $normalizedUrl;
    }

    /**
     * Performs an HTTP request.
     *
     * @param string       $url     The url to fetch
     * @param string|array $content The content of the request
     * @param array        $headers The headers of the request
     * @param string       $method  The HTTP method to use
     *
     * @throws HttpTransportException
     *
     * @return ResponseInterface The response content
     */
    protected function httpRequest($url, $content = null, $headers = [], $method = null)
    {
        if (null === $method) {
            $method = null === $content || '' === $content ? 'GET' : 'POST';
        }

        $headers += array('User-Agent' => 'SPDataBundle (https://github.com/spawnrad/SPDataBundle)');
        if (is_string($content)) {
            $headers += array('Content-Length' => (string)strlen($content));
        } elseif (is_array($content)) {
            $content = http_build_query($content, '', '&');
        }

        if ($this->etag) {
            $headers += array('If-None-Match' => $this->etag);
        }

        $request = new httpRequest($method, $url, $headers, $content);

        try {
            return $this->httpClient->send(
                $method,
                $url,
                $headers,
                $content
            );
        } catch (Exception $e) {
            throw new HttpTransportException('Error while sending HTTP request', $this->getName(), $e->getCode(), $e);
        }
    }

    /**
     * Get the 'parsed' content based on the response headers.
     *
     * @param Response $rawResponse
     *
     * @return array
     */
    protected function getResponseContent(Response $rawResponse)
    {
        // First check that content in response exists, due too bug: https://bugs.php.net/bug.php?id=54484
        $content = (string) $rawResponse->getBody();
        if (!$content) {
            return array();
        }

        $response = json_decode($content, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            parse_str($content, $response);
        }

        return $response;
    }

    /**
     * Generate a non-guessable nonce value.
     *
     * @return string
     */
    protected function generateNonce()
    {
        return md5(microtime(true).uniqid('', true));
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * @param string $etag
     */
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }

    /**
     * @param string $url
     * @param array $parameters
     *
     * @return HttpResponse
     */
    abstract protected function doGetInformationRequest($url, array $parameters = array());

    /**
     * Configure the option resolver
     *
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {

    }
}
