<?php

namespace Application\Controller;

use Application\Storage\SqlLiteRepository;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class DeleteController
{
    /**
     * @var SqlLiteRepository
     */
    private $repository;

    public function __construct(SqlLiteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function delete(Response $response, Request $request, $args)
    {
        $id = $args['id']??0;
        $this->repository->remove($id);

        return $response->withRedirect('/');
    }
}
