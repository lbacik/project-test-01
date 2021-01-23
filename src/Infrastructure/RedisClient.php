<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Service\RedisClient as RedisClientInterface;
use Predis\Client;

class RedisClient implements RedisClientInterface
{
    public const CONN_HOST = 'host';

    public function __construct(
        private Client $redis
    ) {}

    public function keys(): array
    {
        return $this->redis->keys('*');
    }

    public function mget(array $keys): array
    {
        if (empty($keys) === false) {
            $result = $this->redis->mget($keys);
        }
        return $result ?? [];
    }

    public function mset(array $keyValuePairs, int $ttl): void
    {
        foreach($keyValuePairs as $key => $value) {
            $this->redis->setex($key, $ttl, $value);
        }
    }
}
