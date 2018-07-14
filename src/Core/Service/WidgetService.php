<?php
namespace Wambo\Core\Service;

use Wambo\Cms\Domain\Page;
use Wambo\Core\Responder\Widget\MetaWidget;

class WidgetService
{
    public function __construct()
    {
    }

    public function getMetaWidget(Page $page)
    {
        return new MetaWidget($page->getTitle());
    }


}