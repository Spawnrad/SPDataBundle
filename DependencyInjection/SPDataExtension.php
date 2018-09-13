<?php


namespace SP\Bundle\DataBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SPDataExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/'));
        $loader->load('data.yml');
        $loader->load('http_client.xml');

        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        $this->createHttplugClient($container, $config);
        
        // setup services for all configured resource owners
        $resourceOwners = array();
        foreach ($config['resource_owners'] as $name => $options) {
            $resourceOwners[$name] = $name;
            $this->createResourceOwnerService($container, $name, $options);
        }
        $container->setParameter('sp_data.resource_owners', $resourceOwners);

    }

    /**
     * Creates a resource owner service.
     *
     * @param ContainerBuilder $container The container builder
     * @param string           $name      The name of the service
     * @param array            $options   Additional options of the service
     */
    public function createResourceOwnerService(ContainerBuilder $container, $name, array $options)
    {
        // alias services
        if (isset($options['service'])) {
            // set the appropriate name for aliased services, compiler pass depends on it
            $container->setAlias('sp_data.resource_owner.'.$name, $options['service']);
        } else {
            $type = $options['type'];
            unset($options['type']);

            $definition = new DefinitionDecorator('sp_data.abstract_resource_owner.'.Configuration::getResourceOwnerType($type));
            $definition->setClass("%sp_data.resource_owner.$type.class%");
            $definition->replaceArgument(1, $options);
            $definition->replaceArgument(2, $name);

            $container->setDefinition('sp_data.resource_owner.'.$name, $definition);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'sp_data';
    }    /**
    * @param ContainerBuilder $container
    * @param array            $config
    */
   protected function createHttplugClient(ContainerBuilder $container, array $config)
   {
       $httpClientId = $config['http']['client'];
       $httpMessageFactoryId = $config['http']['message_factory'];
       $bundles = $container->getParameter('kernel.bundles');

       if ('httplug.client.default' === $httpClientId && !isset($bundles['HttplugBundle'])) {
           throw new InvalidConfigurationException(
               'You must setup php-http/httplug-bundle to use the default http client service.'
           );
       }
       if ('httplug.message_factory.default' === $httpMessageFactoryId && !isset($bundles['HttplugBundle'])) {
           throw new InvalidConfigurationException(
               'You must setup php-http/httplug-bundle to use the default http message factory service.'
           );
       }

       $container->setAlias('sp_data.http.client', new Alias($config['http']['client'], true));
       $container->setAlias('sp_data.http.message_factory', new Alias($config['http']['message_factory'], true));
   }
}