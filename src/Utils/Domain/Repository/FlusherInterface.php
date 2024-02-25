<?php

namespace App\Utils\Domain\Repository;

interface FlusherInterface
{
    public function flush(): void;
}