<?php
namespace Wambo\Cms\Responder;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;
use Wambo\Cms\Domain\Page;
use Wambo\Core\Service\WidgetService;

class PageResponder
{
    private $twig;
    private $widgetService;

    public function __construct(Twig $twig, WidgetService $widgetService)
    {
        $this->twig = $twig;
        $this->widgetService = $widgetService;
    }

    public function __invoke(ResponseInterface $response, Page $page)
    {
        $meta = $this->widgetService->getMetaWidget($page);

        return $this->twig->render($response, 'cms/page.twig', [
                'page' => $page,
                'meta' => $meta
            ]
        );
    }
}