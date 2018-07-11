<?php
namespace Wambo\Core;

use DI\ContainerBuilder;
use Wambo\Core;

class App extends \DI\Bridge\Slim\App
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions(WAMBO_ROOT_DIR . '/src/config.php');
    }

    public function registerPackage(RegistrationInterface $package)
    {
        $package->init($this);
    }
}
