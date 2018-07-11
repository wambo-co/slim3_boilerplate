<?php
namespace Wambo\Cms\Action;

use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\UuidFactoryInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Wambo\Cms\Exception\PageNotFoundException;
use Wambo\Cms\Service\PageRepository;

class Page
{
    private $twig;
    private $pageRepository;
    private $uuidFactory;

    public function __construct(Twig $twig, PageRepository $pageRepository, UuidFactoryInterface $uuidFactory)
    {
        $this->twig = $twig;
        $this->pageRepository = $pageRepository;
        $this->uuidFactory = $uuidFactory;
    }

    public function __invoke(string $pageId, Twig $twig, Request $request, Response $response) : ResponseInterface
    {
        try {
            $uuid = $this->uuidFactory->fromString($pageId);
            $page = $this->pageRepository->getById($uuid);
        } catch (PageNotFoundException $e) {
            throw new \Slim\Exception\NotFoundException($request, $response);
        }

        return $twig->render($response, 'cms/page.twig', ['page' => $page]);
    }
}
