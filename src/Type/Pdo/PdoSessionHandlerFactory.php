<?php

namespace FlexSession\Type\Pdo;

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
        $options = [
            'db_table' => $params['table'] ?? 'session',
        ];

        $pdoSessionHandler =  new PdoSessionHandler($this->createPdo($params), $options);
        $pdoSessionHandler->createTable();

        return $pdoSessionHandler;
    }

    private function createPdo($params)
    {
        // TODO PdoFactory
        if (!isset($params['dsn'])) {
            throw new \InvalidArgumentException();
        }

        $pdo = new \PDO($params['dsn']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}