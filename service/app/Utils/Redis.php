<?php
declare(strict_types=1);

namespace App\Utils;

use Hyperf\Redis\RedisFactory;
use Hyperf\Utils\ApplicationContext;

class Redis
{
    protected $poolName = 'default';

    /**
     * @return string
     */
    public static function getPoolName(): string
    {
        return (new static())->poolName;
    }

    public static function getContainer()
    {
        return ApplicationContext::getContainer()->get(RedisFactory::class)->get(self::getPoolName());
    }
}