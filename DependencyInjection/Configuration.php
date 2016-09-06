<?php

namespace Bulhi\MonologDbBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('bulhi_monolog_db');

        // Define the parameter that allows to configure name of used User entity class
        $rootNode
            ->children()
                ->scalarNode('user_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end();

        return $treeBuilder;
    }
}
