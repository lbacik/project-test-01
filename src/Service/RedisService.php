<?php

declare(strict_types=1);

namespace App\Service;

class RedisService
{
    public const DEFAULT_TTL = 30;

    public function __construct(
        private RedisClient $redisClient
    ) {}

    public function getAll(): array
    {
        $keys = $this->redisClient->keys();
        $values = $this->redisClient->mget($keys);

        return array_combine($keys, $values);
    }

    public function set(array $keyValuePairs, int $ttl = self::DEFAULT_TTL): void
    {
        $this->redisClient->mset($keyValuePairs, $ttl);
    }
}
