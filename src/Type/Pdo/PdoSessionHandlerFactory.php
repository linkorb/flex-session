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
    const TYPE = 'pdo';

    /** @var \PDO */
    private $pdo;

    public function create(array $params): AbstractSessionHandler
    {
        $options = [
            'db_table' => $params['table'] ?? 'session',
        ];

        // TODO SessionPdoFactory ?!
        $this->pdo = $this->createPdo($params);

        $pdoSessionHandler = new PdoSessionHandler($this->pdo, $options);
        if (!$this->tableExists($options['db_table'])) {
            $pdoSessionHandler->createTable();
        }

        return $pdoSessionHandler;
    }

    private function tableExists($table)
    {
        try {
            $result = $this->pdo->query("SELECT 1 FROM $table LIMIT 1");
        } catch (\PDOException $e) {
            return false;
        }

        return $result !== false;
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