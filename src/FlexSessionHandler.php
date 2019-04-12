<?php

namespace FlexSession;

use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;

/**
 * Class FlexSessionStorage
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
class FlexSessionHandler extends AbstractSessionHandler
{
    /** @var FlexSessionHandlerFactory */
    private $sessionHandlerFactory;

    /**
     * Decorated session handler
     * @var AbstractSessionHandler
     */
    private $handler;

    public function __construct(FlexSessionHandlerFactory $sessionHandlerFactory)
    {
        $this->sessionHandlerFactory = $sessionHandlerFactory;
        $this->handler = $this->sessionHandlerFactory->create();
    }

    public function open($savePath, $sessionName)
    {
        parent::open($savePath, $sessionName);

        return $this->handler->open($savePath, $sessionName);
    }

    protected function doRead($sessionId)
    {
        return $this->handler->doRead($sessionId);
    }

    protected function doWrite($sessionId, $data)
    {
        return $this->handler->doWrite($sessionId, $data);
    }

    protected function doDestroy($sessionId)
    {
        return $this->handler->doDestroy($sessionId);
    }

    public function close()
    {
        return $this->handler->close();
    }

    public function gc($maxlifetime)
    {
        return $this->handler->gc($maxlifetime);
    }

    public function updateTimestamp($session_id, $session_data)
    {
        return $this->handler->updateTimestamp($session_id, $session_data);
    }
}