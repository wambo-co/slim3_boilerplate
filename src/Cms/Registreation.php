<?php
namespace Wambo\Cms;

use Wambo\Cms\Action\Page;
use Wambo\Core\App;
use Wambo\Core\RegistrationInterface;

class Registreation implements RegistrationInterface
{
    public function init(App $app)
    {
        $app->get('/cms/{pageId}', Page::class)->setName('cms');
    }
}
