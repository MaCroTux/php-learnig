<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/', function (Request $request, Response $response, array $args)
{
    $repository = new \Application\Storage\SqlLiteRepository();
    $controller = new \Application\Controller\IndexController($this->renderer, $repository);
    // Render index view
    return $controller->index($response, $args);
});

$app->get('/crawler/{source}/{id}', function (Request $request, Response $response, array $args)
{
    $repository = new \Application\Storage\SqlLiteRepository();
    $controller = new \Application\Controller\IndexController($this->renderer, $repository);
    // Render index view
    return $controller->index($response, $args);
});

$app->get('/kraken/{id}', function (Request $request, Response $response, array $args)
{
    $kraken = new \Application\Kraken\KrakenPcComponentes($this->logger);
    $repository = new \Application\Storage\SqlLiteRepository();

    $kraken = new \Application\Kraken\KrakenHandler($repository, $kraken);

    $kraken->handle($args['id']);
    
    return $response->withRedirect("/crawler/pccomponentes/".$args['id']);
});

$app->post('/new', function (Request $request, Response $response, array $args)
{
    $name = $request->getParam('name');
    $this->logger->info("New product $name at ".time());
    $repository = new \Application\Storage\SqlLiteRepository();
    $controller = new \Application\Controller\NewController($repository);
    // Render index view
    return $controller->insert($response, $request, $args);
});

$app->get('/delete/{id}', function (Request $request, Response $response, array $args)
{
    $id = $args['id'];
    $this->logger->info("Delete productId $id at ".time());
    $repository = new \Application\Storage\SqlLiteRepository();
    $controller = new \Application\Controller\DeleteController($repository);
    // Render index view
    return $controller->delete($response, $request, $args);
});
