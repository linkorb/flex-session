<?php

namespace FlexSession\Type\Memcached;

use FlexSession\Type\SessionHandlerFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;

/**
 * Class MemcachedSessionHandlerFactory
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
class MemcachedSessionHandlerFactory implements SessionHandlerFactoryInterface
{
    public function create(array $params): AbstractSessionHandler
    {
        return new MemcachedSessionHandler($this->createClient($params));
    }

    private function createClient(array $params)
    {
        // TODO MemcachedClientFactory

        $memcached = new \Memcached();

        $host = isset($params['server']) ?? '127.0.0.1';
        $parts = explode(':', $host);
        $port = isset($parts[1]) ?? 11211;
        $memcached->addServer($host, $port);

        return $memcached;
    }
}