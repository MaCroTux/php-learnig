<?php

namespace Application\Controller;

use Application\Storage\SqlLiteRepository;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class IndexController
{
    /**
     * @var PhpRenderer
     */
    private $renderer;
    /**
     * @var SqlLiteRepository
     */
    private $repository;

    public function __construct(PhpRenderer $renderer, SqlLiteRepository $repository)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
    }

    public function index(Response $response, $args): ResponseInterface
    {
        $productId = $args['id'];
        $source = $args['source'];

        $args['sources'] = null;
        if (!empty($args['source']) && !empty($args['id'])) {
            $args['sources'] = $this->repository->getSource($source, $productId);
        }

        $args['products'] = $this->repository->all();

        return $this->renderer->render($response, 'index.phtml', $args);
    }
}
