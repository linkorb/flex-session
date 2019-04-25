<?php

namespace FlexSessionTest;

use FlexSession\FlexSessionHandler;
use FlexSession\FlexSessionHandlerFactory;
use FlexSession\TypeProvider\SimpleProvider;
use FlexSession\Type\File\FileSessionHandlerFactory;
use FlexSession\Type\Memcached\MemcachedSessionHandlerFactory;
use FlexSession\Type\Pdo\PdoSessionHandlerFactory;
use FlexSession\TypeProvider\TypeProviderFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

/**
 * Class FlexSessionTest
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class FlexSessionTest extends TestCase
{
    public function testNative()
    {
        $handler = new NativeFileSessionHandler();
        $storage = new NativeSessionStorage([], $handler);
        $session = new Session($storage);
        $session->start();

        $session->set('_test', 'value');
        $this->assertEquals('value', $session->get('_test'));
    }

    public function testFileFlexSession()
    {
        $typeProvider = new SimpleProvider();
        $typeProvider->type = ['type' => 'file'];

        $handler = $this->createFlexSessionHandler($typeProvider);

        $storage = new NativeSessionStorage([], $handler);
        $session = new Session($storage);
        $session->start();
        $this->assertNotNull($session->getId());
        $this->assertNull($session->get('something'));
        session_id('sessionid');
        $this->assertEquals('sessionid', $session->getId());

        $session->set('_test', 'value');
        $this->assertEquals('value', $session->get('_test'));
    }

    public function testPdoFlexSession()
    {
        $typeProvider = new SimpleProvider();
        $typeProvider->type = ['type' => 'pdo', 'dsn' => 'sqlite::memory:'];

        $handler = $this->createFlexSessionHandler($typeProvider);


        $storage = new NativeSessionStorage([], $handler);
        $session = new Session($storage);
        $session->start();
        $this->assertNotNull($session->getId());
        $this->assertNull($session->get('something'));
        session_id('sessionid');
        $this->assertEquals('sessionid', $session->getId());
        $session->set('_test', 'value');
        $this->assertEquals('value', $session->get('_test'));
    }

    public function testResolveParamsFromLine()
    {
        $dsn = 'mysql:host=localhost;dbname=testdb';
        $line = "pdo?dsn=$dsn&username=x&password=y&table=session_table";
        $params = TypeProviderFactory::resolveParamsFromLine($line);

        $this->assertEquals([
            'type' => 'pdo',
            'dsn' => $dsn,
            'username' => 'x',
            'password' => 'y',
            'table' => 'session_table'
        ], $params);
    }

    private function createFlexSessionHandler(SimpleProvider $typeProvider): FlexSessionHandler
    {
        $handlerFactory = new FlexSessionHandlerFactory($typeProvider);
        $handlerFactory->addType('file', new FileSessionHandlerFactory());
        $handlerFactory->addType('memcached', new MemcachedSessionHandlerFactory());
        $handlerFactory->addType('pdo', new PdoSessionHandlerFactory());


        $handler = new FlexSessionHandler($handlerFactory);

        return $handler;
    }
}