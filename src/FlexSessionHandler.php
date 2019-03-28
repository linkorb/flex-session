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
    /** @var AbstractSessionHandler */
    private $handler;

    public function __construct(FlexSessionHandlerFactory $sessionHandlerFactory)
    {
        $this->sessionHandlerFactory = $sessionHandlerFactory;
    }

    protected function doRead($sessionId)
    {
        return $this->getDecoratedHandler()->doRead($sessionId);
    }

    protected function doWrite($sessionId, $data)
    {
        return $this->getDecoratedHandler()->doWrite($sessionId, $data);
    }

    protected function doDestroy($sessionId)
    {
        return $this->getDecoratedHandler()->doDestroy($sessionId);
    }

    public function close()
    {
        return $this->getDecoratedHandler()->close();
    }

    public function gc($maxlifetime)
    {
        return $this->getDecoratedHandler()->gc($maxlifetime);
    }

    public function updateTimestamp($session_id, $session_data)
    {
        return $this->getDecoratedHandler()->updateTimestamp($session_id, $session_data);
    }

    protected function getDecoratedHandler(): AbstractSessionHandler
    {
        if (!$this->handler) {
            $this->handler = $this->sessionHandlerFactory->create();
        } else {
            $shouldSwitch = true;

            if ($shouldSwitch) {
                $this->handler->close();
                $this->handler = $this->sessionHandlerFactory->create();
            }
        }

        return $this->handler;
    }
    
}