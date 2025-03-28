<?php

namespace SP\Bundle\DataBundle\Utils;

use SP\Bundle\DataBundle\ResourceOwner\ResourceOwnerInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Security\Http\HttpUtils;

class DataUtils
{
    public const SIGNATURE_METHOD_HMAC = 'HMAC-SHA1';
    public const SIGNATURE_METHOD_RSA = 'RSA-SHA1';
    public const SIGNATURE_METHOD_PLAINTEXT = 'PLAINTEXT';

    protected HttpUtils $httpUtils;

    private ServiceLocator $resourceOwnerLocator;

    public function __construct(
        HttpUtils $httpUtils,
        ServiceLocator $resourceOwnerLocator,
    ) {
        $this->httpUtils = $httpUtils;
        $this->resourceOwnerLocator = $resourceOwnerLocator;
    }

    public static function signRequest($method, $url, $parameters, $clientSecret, $tokenSecret = '', $signatureMethod = self::SIGNATURE_METHOD_HMAC)
    {
        // Validate required parameters
        foreach (['oauth_consumer_key', 'oauth_timestamp', 'oauth_nonce', 'oauth_version', 'oauth_signature_method'] as $parameter) {
            if (!isset($parameters[$parameter])) {
                throw new \RuntimeException(sprintf('Parameter "%s" must be set.', $parameter));
            }
        }

        // Remove oauth_signature if present
        // Ref: Spec: 9.1.1 ("The oauth_signature parameter MUST be excluded.")
        if (isset($parameters['oauth_signature'])) {
            unset($parameters['oauth_signature']);
        }

        // Parse & add query params as base string parameters if they exists
        $url = parse_url($url);
        if (isset($url['query'])) {
            parse_str($url['query'], $queryParams);
            $parameters += $queryParams;
        }

        // Remove default ports
        // Ref: Spec: 9.1.2
        $explicitPort = $url['port'] ?? null;
        if (('https' === $url['scheme'] && 443 === $explicitPort) || ('http' === $url['scheme'] && 80 === $explicitPort)) {
            $explicitPort = null;
        }

        // Remove query params from URL
        // Ref: Spec: 9.1.2
        $url = sprintf('%s://%s%s%s', $url['scheme'], $url['host'], $explicitPort ? ':' . $explicitPort : '', $url['path'] ?? '');

        // Parameters are sorted by name, using lexicographical byte value ordering.
        // Ref: Spec: 9.1.1 (1)
        uksort($parameters, 'strcmp');

        // http_build_query should use RFC3986
        $parts = [
            // HTTP method name must be uppercase
            // Ref: Spec: 9.1.3 (1)
            strtoupper($method),
            rawurlencode($url),
            rawurlencode(str_replace(['%7E', '+'], ['~', '%20'], http_build_query($parameters, '', '&'))),
        ];

        $baseString = implode('&', $parts);

        switch ($signatureMethod) {
            case self::SIGNATURE_METHOD_HMAC:
                $keyParts = [
                    rawurlencode($clientSecret),
                    rawurlencode($tokenSecret),
                ];

                $signature = hash_hmac('sha1', $baseString, implode('&', $keyParts), true);
                break;

            case self::SIGNATURE_METHOD_RSA:
                if (!\function_exists('openssl_pkey_get_private')) {
                    throw new \RuntimeException('RSA-SHA1 signature method requires the OpenSSL extension.');
                }

                if (0 === strpos($clientSecret, '-----BEGIN')) {
                    $privateKey = openssl_pkey_get_private($clientSecret, $tokenSecret);
                } else {
                    $privateKey = openssl_pkey_get_private(file_get_contents($clientSecret), $tokenSecret);
                }

                $signature = false;

                openssl_sign($baseString, $signature, $privateKey);
                openssl_free_key($privateKey);
                break;

            case self::SIGNATURE_METHOD_PLAINTEXT:
                $signature = $baseString;
                break;

            default:
                throw new \RuntimeException(sprintf('Unknown signature method selected %s.', $signatureMethod));
        }

        return base64_encode($signature);
    }

    public function getResourceOwner($name)
    {
        if (!$this->resourceOwnerLocator->has($name)) {
            throw new \RuntimeException(sprintf("No resource owner with name '%s'.", $name));
        }

        $resourceOwner = $this->resourceOwnerLocator->get($name);
        if (!$resourceOwner instanceof ResourceOwnerInterface) {
            throw new \RuntimeException(sprintf("Resource owner '%s' is not an instance of ResourceOwnerInterface.", $name));
        }

        return $resourceOwner;
    }
}
