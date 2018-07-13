<?php

namespace Alicorn\LokaliseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('alicorn_lokalise');

        $rootNode
            ->children()
            ->scalarNode('host')
                ->defaultValue('https://s3-eu-west-1.amazonaws.com/lokalise-assets/')
                ->end()
            ->scalarNode('web_path')
                ->defaultNull()
                ->end()
            ->scalarNode('symfony_path')
                ->defaultNull()
                ->end()
            ->scalarNode('extract_file')
                ->defaultValue('/tmp/langs.zip')
                ->end()
            ->arrayNode('api')
                ->children()
                ->scalarNode('api_token')
                    ->defaultNull()
                    ->end()
                ->scalarNode('project_id')
                    ->defaultNull()
                    ->end()
                ->scalarNode('type')
                    ->defaultValue('json')
                    ->end()
                ->scalarNode('use_original')
                    ->defaultValue(1)
                    ->end()
                ->scalarNode('bundle_structure')
                    ->defaultValue('%%LANG_ISO%%.%%FORMAT%%')
                    ->end()
                ->scalarNode('base_url')
                    ->defaultValue('https://lokalise.co/api/')
                    ->end()
                ->scalarNode('directory_prefix')
                    ->defaultValue('%%LANG_ISO%%')
                    ->end()
                ->end()
                ->end()
            ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
