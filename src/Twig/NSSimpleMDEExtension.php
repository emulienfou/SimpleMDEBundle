<?php

namespace NS\SimpleMDEBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class NSSimpleMDEExtension
 *
 * @package NS\SimpleMDEBundle\Twig
 */
class NSSimpleMDEExtension extends \Twig_Extension
{

    /**
     * @var ContainerInterface $container Container interface
     */
    protected $container;

    /**
     * Initialize trumbowyg helper
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Gets a service.
     *
     * @param string $id The service identifier
     *
     * @return object The associated service
     */
    public function getService($id)
    {
        return $this->container->get($id);
    }

    /**
     * Get parameters from the service container
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getParameter($name)
    {
        return $this->container->getParameter($name);
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return [new \Twig_Function('simplemde_js', [$this, 'simplemdeJs'], ['is_safe' => ['html']])];
    }

    /**
     * @return string
     */
    public function simplemdeJs()
    {
        $config = $this->getParameter('ns_simplemde.config');

        return $this->getService('templating')->render('NSSimpleMDEBundle:Init:js.html.twig', [
            'config' => json_encode($config)
        ]);
    }
}