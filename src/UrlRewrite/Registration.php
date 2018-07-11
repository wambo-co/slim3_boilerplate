<?php
namespace Wambo\UrlRewrite;

use Wambo\Core\App;
use Wambo\Core\RegistrationInterface;
use Wambo\UrlRewrite\Action\UrlRewrite;

class Registration implements RegistrationInterface
{
    public function init(App $app)
    {
        // add Middleware
        $app->add(UrlRewrite::class);
    }
}
