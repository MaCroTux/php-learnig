<?php

namespace Application\Kraken;

interface Kraken
{
    public function source(): string;

    public function execute($findProduct): array;
}
