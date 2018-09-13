<?php

namespace SP\Bundle\DataBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration for the extension
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Array of supported resource owners, indentation is intentional to easily notice
     * which resource is of which type.
     *
     * @var array
     */
    private static $resourceOwners = array(
        'oauth2' => array(
            'facebook',
            'youtube',
            'instagram',
        ),
        'oauth1' => array(
            'twitter',
        ),
    );

    /**
     * Return the type (OAuth1 or OAuth2) of given resource owner.
     *
     * @param string $resourceOwner
     *
     * @return string
     */
    public static function getResourceOwnerType($resourceOwner)
    {
        $resourceOwner = current(explode('.', $resourceOwner));

        if ('oauth1' === $resourceOwner || 'oauth2' === $resourceOwner) {
            return $resourceOwner;
        }

        if (in_array($resourceOwner, static::$resourceOwners['oauth1'])) {
            return 'oauth1';
        }

        return 'oauth2';
    }

    /**
     * Checks that given resource owner is supported by this bundle.
     *
     * @param string $resourceOwner
     *
     * @return Boolean
     */
    public static function isResourceOwnerSupported($resourceOwner)
    {
        $resourceOwner = current(explode('.', $resourceOwner));

        if ('oauth1' === $resourceOwner || 'oauth2' === $resourceOwner) {
            return true;
        }

        return in_array($resourceOwner, static::$resourceOwners['oauth1']) || in_array($resourceOwner, static::$resourceOwners['oauth2']);
    }

    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder $builder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        $rootNode = $builder->root('sp_data');

        $this->addHttpClientConfiguration($rootNode);
        $this->addResourceOwnersConfiguration($rootNode);

        return $builder;
    }

    private function addResourceOwnersConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->fixXmlConfig('resource_owner')
            ->children()
            ->arrayNode('resource_owners')
            ->isRequired()
            ->useAttributeAsKey('name')
            ->prototype('array')
            ->ignoreExtraKeys()
            ->children()
            ->scalarNode('infos_url')
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenUnset()
            ->end()
            ->end()
            ->scalarNode('client_id')->end()
            ->scalarNode('client_secret')->end()
            ->scalarNode('realm')
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenUnset()
            ->end()
            ->end()
            ->scalarNode('response_class')
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenUnset()
            ->end()
            ->end()
            ->scalarNode('service')
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenUnset()
            ->end()
            ->end()
            ->scalarNode('type')
            ->validate()
            ->ifTrue(function ($type) {
                return !Configuration::isResourceOwnerSupported($type);
            })
            ->thenInvalid('Unknown resource owner type "%s".')
            ->end()
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenUnset()
            ->end()
            ->end()
            ->arrayNode('paths')
            ->useAttributeAsKey('name')
            ->prototype('variable')
            ->validate()
            ->ifTrue(function ($v) {
                if (null === $v) {
                    return true;
                }

                if (is_array($v)) {
                    return 0 === count($v);
                }

                if (is_string($v)) {
                    return empty($v);
                }

                return !is_numeric($v);
            })
            ->thenInvalid('Path can be only string or array type.')
            ->end()
            ->end()
            ->end()
            ->arrayNode('options')
            ->useAttributeAsKey('name')
            ->prototype('scalar')->end()
            ->end()
            ->end()
            ->validate()
            ->ifTrue(function ($c) {
                // skip if this contains a service
                if (isset($c['service'])) {
                    return false;
                }

                // for each type at least these have to be set
                foreach (array('type') as $child) {
                    if (!isset($c[$child])) {
                        return true;
                    }
                }

                return false;
            })
            ->thenInvalid("You should set at least the 'type' of a resource owner.")
            ->end()
            ->validate()
            ->ifTrue(function ($c) {
                // skip if this contains a service
                if (isset($c['service'])) {
                    return false;
                }

                // Only validate the 'oauth2' and 'oauth1' type
                if ('oauth2' !== $c['type'] && 'oauth1' !== $c['type']) {
                    return false;
                }
            })
            ->thenInvalid("All parameters are mandatory for types 'oauth2' and 'oauth1'. Check if you're missing one of: 'access_token_url', 'authorization_url', 'infos_url' and 'request_token_url' for 'oauth1'.")
            ->end()
            ->validate()
            ->ifTrue(function ($c) {
                // skip if this contains a service
                if (isset($c['service'])) {
                    return false;
                }

                // Only validate the 'oauth2' and 'oauth1' type
                if ('oauth2' !== $c['type'] && 'oauth1' !== $c['type']) {
                    return false;
                }

                // one of this two options must be set
                if (0 === count($c['paths'])) {
                    return !isset($c['response_class']);
                }

                foreach (array('identifier') as $child) {
                    if (!isset($c['paths'][$child])) {
                        return true;
                    }
                }

                return false;
            })
            ->thenInvalid("At least the 'identifier', 'nickname' and 'realname' paths should be configured for 'oauth2' and 'oauth1' types.")
            ->end()
            ->validate()
            ->ifTrue(function ($c) {
                if (isset($c['service'])) {
                    // ignore paths & options if none were set
                    return 0 !== count($c['paths']) || 0 !== count($c['options']) || 3 < count($c);
                }

                return false;
            })
            ->thenInvalid("If you're setting a 'service', no other arguments should be set.")
            ->end()
            ->end()
            ->end()
            ->end();
    }

    private function addHttpClientConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('http')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('client')->defaultValue('httplug.client.default')->end()
                        ->scalarNode('message_factory')->defaultValue('httplug.message_factory.default')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
