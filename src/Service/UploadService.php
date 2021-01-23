<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Items;

class UploadService
{
    public function __construct(
        private RedisService $redisService
    ) {}

    /** @param Items[] $items */
    public function uploadToRedis(array $items): void
    {
        $keyValuePairs = array_reduce(
            $items,
            fn($result, $item) => array_merge($result, [$item->getName() => $item->getValue()]),
            []
        );
        $this->redisService->set($keyValuePairs);
    }
}
