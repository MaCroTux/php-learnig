<?php

namespace Application\Kraken;

use Application\Storage\SqlLiteRepository;

class KrakenHandler
{
    private const HIGH_PRIORITY = 1;
    private const MID_PRIORITY  = 2;
    private const LOW_PRIORITY  = 3;

    private const HIGH_PRIORITY_TIMER = 30;
    private const MID_PRIORITY_TIMER  = 240;
    private const LOW_PRIORITY_TIMER  = 3600;

    private const MAX_SEARCH_RESULT   = 20;
    /**
     * @var SqlLiteRepository
     */
    private $repository;
    /**
     * @var Kraken
     */
    private $kraken;

    public function __construct(SqlLiteRepository $repository, Kraken $kraken)
    {
        $this->repository = $repository;
        $this->kraken = $kraken;
    }

    public function handle(string $productId)
    {

        $product = $this->repository->byId($productId);

        $search = array_slice($this->kraken->execute($product['name']), 0, self::MAX_SEARCH_RESULT);

        $this->repository->save($search, $productId);
    }
}
