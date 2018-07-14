<?php
namespace Wambo\Cms\Action;

use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\UuidFactoryInterface;
use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;
use Wambo\Cms\Exception\PageNotFoundException;
use Wambo\Cms\Responder\PageResponder;
use Wambo\Cms\Service\PageRepository;

class Page
{
    private $pageRepository;
    private $uuidFactory;

    public function __construct(PageRepository $pageRepository, UuidFactoryInterface $uuidFactory)
    {
        $this->pageRepository = $pageRepository;
        $this->uuidFactory = $uuidFactory;
    }

    public function __invoke(string $pageId, PageResponder $pageResponder, Request $request, Response $response) : ResponseInterface
    {
        try
        {
            $uuid = $this->uuidFactory->fromString($pageId);
            $page = $this->pageRepository->getById($uuid);
        }
        catch (PageNotFoundException $e)
        {
            throw new NotFoundException($request, $response);
        }

        return $pageResponder($response, $page);
    }
}
