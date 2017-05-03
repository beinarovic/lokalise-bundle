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
            ->variableNode('host')
                ->defaultValue('https://s3-eu-west-1.amazonaws.com/lokalise-assets/')
                ->end()
            ->variableNode('web_path')
                ->defaultNull()
                ->end()
            ->variableNode('symfony_path')
                ->defaultNull()
                ->end()
            ->variableNode('extract_file')
                ->defaultValue('/tmp/langs.zip')
                ->end()
            ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
