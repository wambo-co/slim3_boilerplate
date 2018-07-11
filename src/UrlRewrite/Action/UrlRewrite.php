<?php
namespace Wambo\UrlRewrite\Action;

use Exception;
use Slim\Http\Request;
use Slim\Http\Response;
use Wambo\UrlRewrite\Service\UrlRepository;

class UrlRewrite
{
    private $urlRepository;

    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        $uri = $request->getUri();
        $uriPath = $uri->getPath();

        try {
            $targetPath = $this->urlRepository->getTarget($uriPath);
            $request = $request->withUri($uri->withPath($targetPath));
        } catch (Exception $exception) {
            // no rewrite found
        }

        $response = $next($request, $response);
        return $response;
    }
}
