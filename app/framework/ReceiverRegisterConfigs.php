<?php
declare(strict_types=1);

namespace Framework;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class ReceiverRegisterConfigs
{
    /**
     * @var ContainerBuilder
     */
    private $containerBuilder;

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    /**
     * @return ContainerBuilder
     */
    public function registerConfigs(): ContainerBuilder
    {
        try {
            $fileLocator = new FileLocator('../app/config/'); //__DIR__ . DIRECTORY_SEPARATOR . 'config');

            $loader = new PhpFileLoader($this->containerBuilder, $fileLocator);
            $loader->load('parameters.php');
        } catch (\Throwable $e) {
            die('Cannot read the config file. File: ' . __FILE__ . '. Line: ' . __LINE__);
        }
        return $this->containerBuilder;
    }
}
