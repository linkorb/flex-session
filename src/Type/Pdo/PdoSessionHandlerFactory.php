<?php

namespace FlexSession\Type\File;

use FlexSession\Type\SessionHandlerFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

/**
 * Class PdoSessionHandlerFactory
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
class PdoSessionHandlerFactory implements SessionHandlerFactoryInterface
{
    public function create(array $params): AbstractSessionHandler
    {
        return new PdoSessionHandler($this->createPdo($params));
    }

    private function createPdo($params)
    {
        // TODO PdoFactory

        if (!isset($params['username'])) {
            throw new \InvalidArgumentException(); // TODO custom own exception
        }

        if (!isset($params['password'])) {
            throw new \InvalidArgumentException();
        }

        if (!isset($params['dns'])) {
            throw new \InvalidArgumentException();
        }

        $dns = $params['dns'];
        $pdo = new \PDO($dns, $params['username'], $params['password']);

        return $pdo;
    }
}