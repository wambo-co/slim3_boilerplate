<?php
namespace Wambo;

use DI\Container;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig_Extension_Debug;
use Wambo\Core\Service\Database;

return [
    'settings.responseChunkSize' => 4096,
    'settings.outputBuffering' => 'append',
    'settings.determineRouteBeforeAppMiddleware' => false,
    'settings.displayErrorDetails' => true,
    'settings.debug' => true,

    'settings.db' => [
        'host' => 'mysql',
        'user' => 'root',
        'password' => 'pw',
        'database' => 'app'
    ],


    UuidFactoryInterface::class => function (): UuidFactoryInterface {
        return new UuidFactory();
    },

    Twig::class => function (Container $container) {
        $view = new Twig(__DIR__ . '/../view/', [
            'cache' => '/tmp',
            'debug' => $container->get('settings.debug')
        ]);
        // Instantiate and add Slim specific extension
        $router = $container->get('router');

        $request = $container->get('request');

        $basePath = rtrim(str_ireplace('index.php', '', $request->getUri()->getBasePath()), '/');
        $view->addExtension(new Twig_Extension_Debug());
        $view->addExtension(new TwigExtension($router, $basePath));

        return $view;
    },

    Database::class => function (Container $container) {
        $settings = $container->get('settings.db');
        return new Database(
            'mysql',
            $settings['host'],
            $settings['database'],
            $settings['user'],
            $settings['password']
        );
    }

];
