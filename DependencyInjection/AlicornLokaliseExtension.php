<?php

namespace Alicorn\LokaliseBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class AlicornLokaliseExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processedConfig = $this->processConfiguration($configuration, $configs);

        $container->setParameter( 'alicorn_lokalise.host', $processedConfig[ 'host' ]);
        $container->setParameter( 'alicorn_lokalise.web_path', $processedConfig[ 'web_path' ]);
        $container->setParameter( 'alicorn_lokalise.symfony_path', $processedConfig[ 'symfony_path' ]);
        $container->setParameter( 'alicorn_lokalise.extract_file', $processedConfig[ 'extract_file' ]);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
