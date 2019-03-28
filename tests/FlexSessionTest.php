<?php

namespace FlexSessionTest;

use FlexSession\FlexSessionHandler;
use FlexSession\FlexSessionHandlerFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NullSessionHandler;
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
    public function testFlexSession()
    {
        // TODO remove
        $storage = new NativeSessionStorage([], new NullSessionHandler());
        $session = new Session($storage);
        $session->start();
        $this->assertNotNull($session->getId());
        $this->assertNull($session->get('something'));
        session_id('nullsessionstorage');
        $this->assertEquals('nullsessionstorage', $session->getId());


        $flexHandler = new FlexSessionHandler(new FlexSessionHandlerFactory());
        $session = new Session(new NativeSessionStorage([], $flexHandler));

        // $session->start();

        $session->set('_test', 'value');
        $this->assertEquals('value', $session->get('_test'));
    }
}