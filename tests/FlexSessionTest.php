<?php

namespace FlexSessionTest;

use FlexSession\FlexSessionHandler;
use FlexSession\FlexSessionHandlerFactory;
use FlexSession\Type\File\FileSessionHandlerFactory;
use FlexSession\Type\Memcached\MemcachedSessionHandlerFactory;
use FlexSession\Type\Pdo\PdoSessionHandlerFactory;
use FlexSessionTest\Stubs\FlexSessionTypeProvider;
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

    private function createFlexSessionHandler(FlexSessionTypeProvider $typeProvider)
    {
        $handlerFactory = new FlexSessionHandlerFactory($typeProvider);
        $handlerFactory->addType('file', new FileSessionHandlerFactory());
        $handlerFactory->addType('memcached', new MemcachedSessionHandlerFactory());
        $handlerFactory->addType('pdo', new PdoSessionHandlerFactory());


        $handler = new FlexSessionHandler($handlerFactory);

        return $handler;
    }

    public function testFlexSession()
    {
        $typeProvider = new FlexSessionTypeProvider();
        $typeProvider->type = ['type' => 'file'];

        $handler = $this->createFlexSessionHandler($typeProvider);

        $storage = new NativeSessionStorage([], $handler);
        $session = new Session($storage);
        $session->start();
        $this->assertNotNull($session->getId());
        $this->assertNull($session->get('something'));
        session_id('nullsessionstorage');
        $this->assertEquals('nullsessionstorage', $session->getId());

        // $storage->setSaveHandler($handler);

        $session->set('_test', 'value');
        $this->assertEquals('value', $session->get('_test'));
    }

    public function testMemcachedFlexSession()
    {
        $typeProvider = new FlexSessionTypeProvider();
        $typeProvider->type = ['type' => 'memcached'];

        $handler = $this->createFlexSessionHandler($typeProvider);


        $storage = new NativeSessionStorage([], $handler);
        $session = new Session($storage);
        $session->start();
        $this->assertNotNull($session->getId());
        $this->assertNull($session->get('something'));
        session_id('nullsessionstorage');
        $this->assertEquals('nullsessionstorage', $session->getId());

        // $storage->setSaveHandler($handler);

        $session->set('_test', 'value');
        $this->assertEquals('value', $session->get('_test'));
    }
}