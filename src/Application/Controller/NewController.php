<?php

namespace Application\Controller;

use Application\Storage\SqlLiteRepository;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class NewController
{
    /**
     * @var SqlLiteRepository
     */
    private $repository;

    public function __construct(SqlLiteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function insert(Response $response, Request $request, $args)
    {
        $name = $request->getParam('name');
        $this->repository->insert($name);

        return $response->withRedirect('/');
    }
}
