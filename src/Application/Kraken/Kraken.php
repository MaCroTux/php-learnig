<?php

namespace Application\Kraken;

interface Kraken
{
    public function execute($findProduct): array;
}
