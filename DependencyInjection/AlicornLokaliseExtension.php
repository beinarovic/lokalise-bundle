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

        $container->setParameter('alicorn_lokalise.host', $processedConfig['host']);
        $container->setParameter('alicorn_lokalise.web_path', $processedConfig['web_path']);
        $container->setParameter('alicorn_lokalise.symfony_path', $processedConfig['symfony_path']);
        $container->setParameter('alicorn_lokalise.extract_file', $processedConfig['extract_file']);

        $apiConfig = $processedConfig['api'];
        if ($apiConfig) {
            $container->setParameter('alicorn_lokalise.api_token', $apiConfig['api_token']);
            $container->setParameter('alicorn_lokalise.project_id', $apiConfig['project_id']);
            $container->setParameter('alicorn_lokalise.type', $apiConfig['type']);
            $container->setParameter('alicorn_lokalise.use_original', $apiConfig['use_original']);
            $container->setParameter('alicorn_lokalise.bundle_structure', $apiConfig['bundle_structure']);
            $container->setParameter('alicorn_lokalise.base_url', $apiConfig['base_url']);
        } else {
            $container->setParameter('alicorn_lokalise.api_token', null);
            $container->setParameter('alicorn_lokalise.project_id', null);
            $container->setParameter('alicorn_lokalise.type', 'json');
            $container->setParameter('alicorn_lokalise.use_original', null);
            $container->setParameter('alicorn_lokalise.bundle_structure', null);
            $container->setParameter('alicorn_lokalise.base_url', 'https://lokalise.co/api/');
        }


        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
