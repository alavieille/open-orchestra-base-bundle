<?php

namespace PHPOrchestra\BaseBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PHPOrchestraBaseExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $languagesAvailables = array('en', 'fr', 'de', 'es');
        if (array_key_exists('languages_availables', $config) && !empty($config['languages_availables'])) {
            $languagesAvailables = $config['languages_availables'];
        }
        $container->setParameter('php_orchestra_base.languages_availables', $languagesAvailables);

        if (array_key_exists('mediatheque_url', $config) && !is_null($config['mediatheque_url'])) {
            $container->setParameter('php_orchestra_base.mediatheque.url', $config['mediatheque_url']);
        } else {
            $container->setParameter('php_orchestra_base.mediatheque.url', 'http://mediatheque.dev');
        }
    }
}
