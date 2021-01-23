<?php

declare(strict_types=1);

namespace App\Service;

interface RedisClient
{
    public function keys(): array;
    public function mget(array $keys): array;
    public function mset(array $keyValuePairs, int $ttl): void;
}
